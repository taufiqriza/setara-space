<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'order_status_updated',
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'description' => "Order #{$order->order_number} status updated to {$order->status}",
                'properties' => [
                    'old_status' => $order->getOriginal('status'),
                    'new_status' => $order->status,
                ],
                'ip_address' => request()->ip(),
            ]);

            // Sync to Merchant Integration (GoFood/Grab)
            // processing -> accept
            // completed -> ready
            // cancelled -> reject
            
            $actionMap = [
                'processing' => 'accept',
                'completed' => 'ready',
                'cancelled' => 'reject'
            ];

            if (isset($actionMap[$order->status])) {
                \App\Jobs\UpdateMerchantOrderStatus::dispatch($order, $actionMap[$order->status]);
            }
        }
        
        if ($order->wasChanged('payment_status') && $order->payment_status === 'paid') {
             Activity::create([
                'user_id' => Auth::id(),
                'action' => 'order_paid',
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'description' => "Order #{$order->order_number} payment received (Rp " . number_format($order->total, 0, ',', '.') . ")",
                'properties' => [
                    'amount' => $order->total,
                    'method' => $order->payment_method,
                ],
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
