<?php

namespace App\Livewire\Control\Activity;

use Livewire\Component;
use App\Models\Activity;
use App\Models\Order;
use Carbon\Carbon;
use Livewire\WithPagination;

class ActivityDashboard extends Component
{
    use WithPagination;

    public $filterUser = null;
    public $filterDate = 'today'; // today, week, month
    public $filterType = 'all'; // all, order, product, system

    public function render()
    {
        // 1. Stats (Mini Analytics)
        $today = Carbon::today();
        
        $stats = [
            'activities_count' => Activity::whereDate('created_at', $today)->count(),
            'orders_count' => Order::whereDate('created_at', $today)->count(),
            'total_sales' => Order::whereDate('created_at', $today)
                                  ->where('payment_status', 'paid')
                                  ->sum('total'),
            'top_action' => Activity::whereDate('created_at', $today)
                                    ->select('action', \DB::raw('count(*) as total'))
                                    ->groupBy('action')
                                    ->orderByDesc('total')
                                    ->first()
        ];
        
        // 2. Activities List
        $activities = Activity::with('user', 'subject')
            ->when($this->filterUser, fn($q) => $q->where('user_id', $this->filterUser))
            ->when($this->filterDate == 'today', fn($q) => $q->whereDate('created_at', Carbon::today()))
            ->when($this->filterDate == 'week', fn($q) => $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]))
            ->when($this->filterDate == 'month', fn($q) => $q->whereMonth('created_at', Carbon::now()->month))
            ->latest()
            ->paginate(20);

        return view('livewire.control.activity.activity-dashboard', [
            'activities' => $activities,
            'stats' => $stats
        ])->layout('layouts.control', ['title' => 'Activity Dashboard']);
    }

    // Helper to get icon based on action
    public function getIcon($action)
    {
        return match($action) {
            'created' => 'fas fa-plus-circle text-green-500',
            'updated' => 'fas fa-edit text-blue-500',
            'deleted' => 'fas fa-trash text-red-500',
            'login' => 'fas fa-sign-in-alt text-gray-500',
            'order_placed' => 'fas fa-shopping-cart text-purple-500',
            default => 'fas fa-info-circle text-gray-400',
        };
    }
}
