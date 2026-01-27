@php
    $title = 'Dashboard';
@endphp

<x-layouts.control :title="$title">
    <div class="p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-500 text-sm">Welcome back, {{ auth()->user()->name ?? 'Admin' }}</p>
                </div>
            </div>
        </div>
        
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Today</span>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Order::whereDate('created_at', today())->count() }}</p>
                <p class="text-gray-500 text-sm">Orders Today</p>
            </div>
            
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format(\App\Models\Order::whereDate('created_at', today())->sum('total'), 0, ',', '.') }}</p>
                <p class="text-gray-500 text-sm">Revenue Today</p>
            </div>
            
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-box text-amber-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Product::where('is_active', true)->count() }}</p>
                <p class="text-gray-500 text-sm">Active Products</p>
            </div>
            
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('is_active', true)->count() }}</p>
                <p class="text-gray-500 text-sm">Active Staff</p>
            </div>
        </div>
        
        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="{{ route('control.pos') }}" class="flex flex-col items-center gap-2 p-4 bg-space-50 hover:bg-space-100 rounded-xl transition-colors">
                    <div class="w-12 h-12 bg-space-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cash-register text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">New Order</span>
                </a>
                <a href="{{ route('control.activity') }}" class="flex flex-col items-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                    <div class="w-12 h-12 bg-gray-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-list-alt text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">View Orders</span>
                </a>
                <a href="{{ route('control.inventory') }}" class="flex flex-col items-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                    <div class="w-12 h-12 bg-gray-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Products</span>
                </a>
                <a href="{{ route('control.report') }}" class="flex flex-col items-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                    <div class="w-12 h-12 bg-gray-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Reports</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.control>
