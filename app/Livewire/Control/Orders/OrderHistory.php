<?php

namespace App\Livewire\Control\Orders;

use Livewire\Component;
use App\Models\Order;
use Carbon\Carbon;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;

    public $filterDate = 'today'; // today, week, month, all
    public $search = '';
    
    // Modal State
    public $showDetailModal = false;
    public $selectedOrder = null;

    protected $listeners = ['refreshOrders' => '$refresh'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterDate()
    {
        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['items', 'user', 'table'])->find($orderId);
        if ($this->selectedOrder) {
            $this->showDetailModal = true;
        }
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedOrder = null;
    }

    public function deleteOrder($orderId)
    {
        try {
            $order = Order::find($orderId);
            if ($order) {
                // Log activity before delete? Maybe later.
                $order->delete(); // Soft delete
                
                $this->dispatch('swal:compact', [
                    'type' => 'success',
                    'text' => 'Order deleted successfully'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('swal:compact', [
                'type' => 'error',
                'text' => 'Failed to delete order'
            ]);
        }
    }

    public function render()
    {
        // Date Logic
        $dateQuery = function($q) {
            if ($this->filterDate == 'today') {
                $q->whereDate('created_at', Carbon::today());
            } elseif ($this->filterDate == 'week') {
                $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($this->filterDate == 'month') {
                $q->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
            }
        };

        // 1. Statistics (Mini Dashboard) - Apply date filter
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')
                ->where($dateQuery)
                ->sum('total'),
            
            'total_orders' => Order::where($dateQuery)->count(),
            
            'avg_order_value' => Order::where('payment_status', 'paid')
                ->where($dateQuery)
                ->avg('total') ?? 0,
                
            'payment_methods' => Order::where($dateQuery)
                ->select('payment_method', \DB::raw('count(*) as count'))
                ->groupBy('payment_method')
                ->orderByDesc('count')
                ->first()
        ];

        // 2. Orders List
        $orders = Order::with(['user', 'table'])
            ->where($dateQuery)
            ->when($this->search, function($q) {
                $q->where(function($sub) {
                    $sub->where('order_number', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.control.orders.order-history', [
            'orders' => $orders,
            'stats' => $stats
        ])->layout('layouts.control', ['title' => 'Order History']);
    }
}
