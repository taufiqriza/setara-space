<div class="h-screen flex flex-col overflow-hidden" wire:poll.10s>
    {{-- Header --}}
    <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
        <div class="flex items-center gap-4">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Activity Log & Analytics</h1>
            </div>
        </div>
        <div>
           {{-- Filters --}}
           <div class="inline-flex bg-gray-100 rounded-lg p-1">
               <button wire:click="$set('filterDate', 'today')" class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200 {{ $filterDate === 'today' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Today</button>
               <button wire:click="$set('filterDate', 'week')" class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200 {{ $filterDate === 'week' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Week</button>
               <button wire:click="$set('filterDate', 'month')" class="px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-200 {{ $filterDate === 'month' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Month</button>
           </div>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6">
        {{-- Mini Analytics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Sales --}}
        <div class="bg-gradient-to-br from-space-600 to-space-800 rounded-2xl p-6 text-white shadow-xl shadow-space-500/20 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-md group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <span class="text-space-100 text-sm font-medium">Total Sales</span>
                </div>
                <div class="text-3xl font-bold tracking-tight">Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}</div>
            </div>
            {{-- Decoration --}}
            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:blur-3xl transition-all duration-500"></div>
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-chart-area text-6xl"></i>
            </div>
        </div>

        {{-- Orders Count --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shopping-bag text-orange-500 text-xl"></i>
                </div>
                <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-full border border-green-100 flex items-center gap-1">
                    <i class="fas fa-arrow-up text-[10px]"></i> {{ $stats['orders_count'] }} New
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['orders_count'] }}</div>
            <div class="text-gray-500 text-sm font-medium">Orders Recieved</div>
        </div>

        {{-- Activity Volume --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
             <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-bolt text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['activities_count'] }}</div>
            <div class="text-gray-500 text-sm font-medium">System Activities</div>
        </div>

         {{-- Top Action --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
             <div class="flex items-center justify-between mb-4">
                 <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-chart-pie text-pink-500 text-xl"></i>
                </div>
            </div>
            <div class="text-xl font-bold text-gray-900 capitalize truncate mb-1" title="{{ $stats['top_action']->action ?? 'N/A' }}">{{ str_replace('_', ' ', $stats['top_action']->action ?? 'N/A') }}</div>
            <div class="text-gray-500 text-sm font-medium">Most Frequent Action</div>
        </div>
    </div>

    {{-- Activity Timeline --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <i class="fas fa-history text-gray-400"></i>
                Recent Activities
            </h3>
            <button wire:click="$refresh" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-space-600 transition-all duration-200">
                <i class="fas fa-sync-alt {{ $activities->isEmpty() ? '' : 'hover:rotate-180 transition-transform duration-500' }}"></i>
            </button>
        </div>
        
        <div class="p-6 md:p-8">
            @if($activities->count() > 0)
                <div class="relative pl-8 md:pl-12 border-l-2 border-dashed border-gray-200 space-y-10">
                    @foreach($activities as $activity)
                        <div class="relative group">
                            {{-- Dot --}}
                            <div class="absolute top-0 -left-[41px] md:-left-[61px] bg-white border-4 border-white rounded-full transition-transform duration-300 group-hover:scale-110 z-10">
                                <div class="w-5 h-5 md:w-8 md:h-8 rounded-full flex items-center justify-center text-[10px] md:text-sm text-white
                                    {{ str_contains($activity->action, 'create') || str_contains($activity->action, 'order') ? 'bg-green-500 shadow-lg shadow-green-200' : '' }}
                                    {{ str_contains($activity->action, 'update') ? 'bg-blue-500 shadow-lg shadow-blue-200' : '' }}
                                    {{ str_contains($activity->action, 'delete') ? 'bg-red-500 shadow-lg shadow-red-200' : '' }}
                                    {{ !str_contains($activity->action, 'create') && !str_contains($activity->action, 'order') && !str_contains($activity->action, 'update') && !str_contains($activity->action, 'delete') ? 'bg-gray-400 shadow-lg shadow-gray-200' : '' }}">
                                    
                                    @if(str_contains($activity->action, 'order')) <i class="fas fa-shopping-cart"></i>
                                    @elseif(str_contains($activity->action, 'login')) <i class="fas fa-sign-in-alt"></i>
                                    @elseif(str_contains($activity->action, 'stock')) <i class="fas fa-box"></i>
                                    @else <i class="fas fa-circle text-[6px]"></i>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 md:gap-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100 hover:border-space-200 hover:shadow-md transition-all duration-300">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center flex-wrap gap-2 mb-2">
                                        <span class="px-2.5 py-0.5 rounded-md text-xs font-bold uppercase tracking-wider
                                            {{ str_contains($activity->action, 'order') ? 'bg-green-100 text-green-700' : '' }}
                                            {{ str_contains($activity->action, 'update') ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ str_contains($activity->action, 'delete') ? 'bg-red-100 text-red-700' : '' }}
                                            {{ !str_contains($activity->action, 'order') && !str_contains($activity->action, 'update') && !str_contains($activity->action, 'delete') ? 'bg-gray-100 text-gray-600' : '' }}">
                                            {{ str_replace('_', ' ', $activity->action) }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
                                            <i class="far fa-clock"></i> {{ $activity->created_at->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-800 font-medium mb-3 break-words">{{ $activity->description }}</p>
                                    
                                    {{-- Detailed Properties View --}}
                                    @if($activity->properties)
                                        <div class="mt-4 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                                            @if(isset($activity->properties['amount']))
                                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Transaction Details</span>
                                                    <span class="text-base font-bold text-space-700">Rp {{ number_format($activity->properties['amount'], 0, ',', '.') }}</span>
                                                </div>
                                            @endif

                                            {{-- Items List (Horizontal Scroll) --}}
                                            @if(isset($activity->properties['items']) && is_array($activity->properties['items']))
                                                <div class="p-4 border-b border-gray-100 bg-space-50/20">
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Ordered Products</p>
                                                    <div class="flex overflow-x-auto pb-2 gap-3 snap-x scrollbar-hide">
                                                        @foreach($activity->properties['items'] as $item)
                                                            <div class="flex-shrink-0 w-40 p-3 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow snap-center flex flex-col gap-2">
                                                                <div class="flex items-start justify-between">
                                                                    <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-orange-500 flex-shrink-0">
                                                                         <i class="fas fa-utensils text-xs"></i>
                                                                    </div>
                                                                    <span class="text-xs font-bold bg-gray-900 text-white px-2 py-0.5 rounded-md shadow-sm">x{{ $item['qty'] ?? 1 }}</span>
                                                                </div>
                                                                <div class="min-w-0">
                                                                    <p class="text-[13px] font-bold text-gray-800 leading-tight mb-0.5 truncate" title="{{ $item['name'] ?? 'Unknown' }}">{{ $item['name'] ?? 'Unknown Item' }}</p>
                                                                    @if(isset($item['price']))
                                                                        <p class="text-[11px] text-gray-500">@ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            {{-- Other Properties --}}
                                            @php
                                                $otherProps = collect($activity->properties)->except(['amount', 'items', 'items_count'])->toArray();
                                            @endphp
                                            
                                            @if(count($otherProps) > 0)
                                                <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-8">
                                                   @foreach($otherProps as $key => $val)
                                                        <div class="flex flex-col min-w-0">
                                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">{{ str_replace('_', ' ', $key) }}</span>
                                                            <span class="text-sm text-gray-700 font-medium break-all whitespace-normal">
                                                                @if(is_array($val))
                                                                    <code class="text-xs text-pink-600 bg-pink-50 px-1 py-0.5 rounded border border-pink-100">{{ json_encode($val) }}</code>
                                                                @elseif(is_bool($val))
                                                                    <span class="px-2 py-0.5 rounded text-xs font-bold {{ $val ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $val ? 'True' : 'False' }}</span>
                                                                @else
                                                                    {{ $val }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                   @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- User Badge --}}
                                <div class="flex items-center md:flex-col md:items-end gap-3 md:gap-1 flex-shrink-0">
                                    @if($activity->user)
                                        <div class="flex items-center gap-2 pl-3 md:pl-0 border-l md:border-l-0 md:border-b border-gray-200 md:pb-2">
                                            <div class="text-right hidden md:block max-w-[120px]">
                                                <p class="text-sm font-bold text-gray-900 leading-tight truncate">{{ $activity->user->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $activity->user->roles->first()->name ?? 'Staff' }}</p>
                                            </div>
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-space-100 to-space-200 border-2 border-white shadow-sm flex items-center justify-center text-xs font-bold text-space-700">
                                                {{ substr($activity->user->name, 0, 1) }}
                                            </div>
                                            <div class="md:hidden">
                                                <p class="text-sm font-bold text-gray-900">{{ $activity->user->name }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 border-2 border-white shadow-sm flex items-center justify-center">
                                                <i class="fas fa-robot text-gray-500 text-xs"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-500">System</span>
                                        </div>
                                    @endif
                                    
                                    <span class="text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded-full border border-gray-100 ml-auto md:ml-0 md:mt-2 whitespace-nowrap">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-10 pt-6 border-t border-gray-100">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard-list text-gray-300 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum ada aktivitas</h3>
                    <p class="text-gray-500 max-w-sm mx-auto mt-1">Aktivitas sistem akan muncul di sini setelah transaksi atau perubahan data dilakukan.</p>
                </div>
            @endif
        </div>
    </div>
    </div>
</div>
