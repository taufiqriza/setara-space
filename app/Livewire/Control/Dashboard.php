<?php

namespace App\Livewire\Control;

use Livewire\Component;
use App\Models\Order;
use App\Models\Activity;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Key Metrics (Today)
        $today = Carbon::today();
        
        $metrics = [
            'revenue' => Order::whereDate('created_at', $today)
                              ->where('status', '!=', 'cancelled')
                              ->sum('total'),
                              
            'orders_count' => Order::whereDate('created_at', $today)
                                   ->count(),
                                   
            'active_orders' => Order::whereIn('status', ['pending', 'on_kitchen', 'to_be_served'])
                                    ->count(),
                                    
            'items_sold' => OrderItem::whereHas('order', function($q) use ($today) {
                                $q->whereDate('created_at', $today)
                                  ->where('status', '!=', 'cancelled');
                            })->sum('quantity')
        ];

        // 2. Recent Sales Chart (Last 7 Days)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                            ->where('status', '!=', 'cancelled')
                            ->sum('total');
            $chartData[] = [
                'date' => $date->format('D, d M'),
                'revenue' => $revenue
            ];
        }

        // 3. Top Products (Today)
        $topProducts = OrderItem::select('product_id', DB::raw('sum(quantity) as total_qty'))
                                ->whereHas('order', function($q) use ($today) {
                                    $q->whereDate('created_at', $today)
                                      ->where('status', '!=', 'cancelled');
                                })
                                ->groupBy('product_id')
                                ->orderByDesc('total_qty')
                                ->take(5)
                                ->with('product') // Eager load
                                ->get();

        // 4. Recent Activities / Orders
        $recentOrders = Order::with(['user', 'table'])
                             ->latest()
                             ->take(5)
                             ->get();

        return view('livewire.control.dashboard', [
            'metrics' => $metrics,
            'chartData' => $chartData,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
            'greeting' => $this->getGreeting()
        ])->layout('layouts.control');
    }

    private function getGreeting()
    {
        $hour = Carbon::now()->hour;
        if ($hour < 12) return 'Good Morning';
        if ($hour < 17) return 'Good Afternoon';
        return 'Good Evening';
    }
}
