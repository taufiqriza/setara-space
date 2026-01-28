<div 
    x-data="{ 
        expanded: $persist(true).as('pos_active_orders_expanded'),
        hasOrders: {{ $recentOrders->count() > 0 ? 'true' : 'false' }},
        toggle() { this.expanded = !this.expanded }
    }"
    x-init="$watch('hasOrders', value => {
        if(!value) expanded = false;
        else expanded = true;
    })"
    wire:poll.15s
    class="bg-white border-t border-gray-200 flex flex-col flex-shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20 transition-all duration-300 ease-in-out"
    :class="expanded ? 'h-40' : 'h-10'"
>
    {{-- Toolbar Header --}}
    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100 bg-gray-50/50 backdrop-blur-sm cursor-pointer hover:bg-gray-100 transition-colors h-10"
         @click="toggle()">
        
        <div class="flex items-center gap-3">
            {{-- Chevron --}}
            <div class="transform transition-transform duration-300 text-gray-400" 
                 :class="expanded ? 'rotate-180' : 'rotate-0'">
                <i class="fas fa-chevron-up"></i>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Queue</span>
                @if($recentOrders->count() > 0)
                <span class="px-2 py-0.5 bg-space-600 text-white text-[10px] font-bold rounded-full shadow-sm shadow-space-200 animate-in zoom-in duration-200">
                    {{ $recentOrders->count() }}
                </span>
                @endif
                
                {{-- Refresh Indicator --}}
                <div wire:loading wire:target="poll" class="ml-2">
                    <i class="fas fa-sync fa-spin text-[10px] text-gray-300"></i>
                </div>
            </div>
            
            {{-- Quick Filters (Only visible when expanded) --}}
            <div class="hidden sm:flex bg-white p-0.5 rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-200"
                 :class="expanded ? 'opacity-100 pointer-events-auto delay-100' : 'opacity-0 pointer-events-none'">
                <button wire:click.stop="setActiveOrderFilter('all')" class="flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded transition-colors {{ $activeOrderFilter === 'all' ? 'bg-space-600 text-white shadow-sm' : 'text-gray-400 hover:bg-gray-50' }}">
                    All
                </button>
                <button wire:click.stop="setActiveOrderFilter('dine_in')" class="flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded transition-colors {{ $activeOrderFilter === 'dine_in' ? 'bg-space-600 text-white shadow-sm' : 'text-gray-400 hover:bg-gray-50' }}">
                    Dine In
                </button>
                <button wire:click.stop="setActiveOrderFilter('online')" class="flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded transition-colors {{ $activeOrderFilter === 'online' ? 'bg-space-600 text-white shadow-sm' : 'text-gray-400 hover:bg-gray-50' }}">
                    Online
                    @if($onlineOrdersCount > 0)
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    @endif
                </button>
            </div>
        </div>

        <a href="{{ route('control.orders') }}" wire:navigate @click.stop class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-space-600 hover:text-space-800 transition-colors bg-white px-3 py-1.5 rounded-lg border border-gray-200 hover:border-space-200 shadow-sm opacity-0 transition-opacity duration-200"
           :class="expanded ? 'opacity-100' : 'opacity-0 pointer-events-none'">
            View All History <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    {{-- Cards Container --}}
    <div class="flex-1 overflow-x-auto scrollbar-hide px-4 py-3 bg-slate-50 min-h-[120px] transition-opacity duration-200" 
         wire:loading.class="opacity-50 pointer-events-none"
         x-show="expanded"
         x-collapse>
        @if($recentOrders->count() > 0)
            <div class="flex gap-3 h-full">
                @foreach($recentOrders as $order)
                    @php
                        $isOnline = in_array($order->payment_method, ['gofood', 'grabfood', 'shopeefood']);
                        $statusStyles = match($order->status) {
                            'pending' => [
                                'bg' => 'bg-amber-50/50 hover:bg-amber-50',
                                'border_l' => 'border-l-amber-500', 
                                'icon' => 'fa-sparkles', 
                                'text' => 'text-amber-600',
                                'label' => 'NEW'
                            ],
                            'on_kitchen', 'processing' => [
                                'bg' => 'bg-blue-50/50 hover:bg-blue-50',
                                'border_l' => 'border-l-blue-500', 
                                'icon' => 'fa-fire-burner', 
                                'text' => 'text-blue-600',
                                'label' => 'COOKING'
                            ],
                            'to_be_served', 'ready' => [
                                'bg' => 'bg-purple-50/50 hover:bg-purple-50',
                                'border_l' => 'border-l-purple-500', 
                                'icon' => 'fa-bell-concierge', 
                                'text' => 'text-purple-600',
                                'label' => 'READY'
                            ],
                            'all_done', 'completed' => [
                                'bg' => 'bg-green-50/50 hover:bg-green-50',
                                'border_l' => 'border-l-green-500', 
                                'icon' => 'fa-check-double', 
                                'text' => 'text-green-600',
                                'label' => 'DONE'
                            ],
                            'cancelled' => [
                                'bg' => 'bg-red-50/50 hover:bg-red-50',
                                'border_l' => 'border-l-red-500', 
                                'icon' => 'fa-ban', 
                                'text' => 'text-red-600',
                                'label' => 'VOID'
                            ],
                            default => [
                                'bg' => 'bg-white',
                                'border_l' => 'border-l-gray-300', 
                                'icon' => 'fa-circle-question', 
                                'text' => 'text-gray-500',
                                'label' => 'UNKNOWN'
                            ]
                        };
                    @endphp

                    <div wire:click="viewOrder({{ $order->id }})" wire:key="order-{{ $order->id }}"
                            class="min-w-[200px] w-[200px] rounded-xl p-3 border border-gray-200 shadow-sm cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-md flex flex-col justify-between relative overflow-hidden group border-l-4 {{ $statusStyles['bg'] }} {{ $statusStyles['border_l'] }}">
                        
                        {{-- Watermark Icon --}}
                        <div class="absolute -right-4 -bottom-4 text-6xl opacity-[0.07] transform rotate-12 pointer-events-none group-hover:scale-110 transition-transform duration-500">
                            <i class="fas {{ $statusStyles['icon'] }}"></i>
                        </div>

                        {{-- Header: Name & Merchant Badge --}}
                        <div class="flex justify-between items-start mb-2 relative z-10">
                            <div class="overflow-hidden">
                                <h4 class="font-bold text-gray-900 text-sm truncate leading-tight">{{ $order->customer_name ?: 'Guest' }}</h4>
                                <span class="text-[10px] text-gray-400 font-mono tracking-tight block mt-0.5">#{{ substr($order->order_number, -4) }}</span>
                            </div>

                            @if($order->payment_method === 'gofood')
                                <div class="w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0" title="GoFood">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gofood_logo.svg/200px-Gofood_logo.svg.png" class="h-3 w-auto" alt="GoFood">
                                </div>
                            @elseif($order->payment_method === 'grabfood')
                                <div class="w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center border border-green-100 flex-shrink-0" title="GrabFood">
                                    <span class="text-[8px] font-black text-green-600 tracking-tighter">GRAB</span>
                                </div>
                            @elseif($order->payment_method === 'shopeefood')
                                <div class="w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center border border-orange-100 flex-shrink-0" title="ShopeeFood">
                                    <span class="text-[8px] font-black text-orange-600 tracking-tighter">SPF</span>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center border border-gray-200 flex-shrink-0">
                                    <i class="fas {{ $order->table ? 'fa-chair' : 'fa-bag-shopping' }} text-[10px] text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Metadata (Driver/Table) --}}
                        <div class="relative z-10 mb-2">
                                @if($isOnline)
                                <div class="bg-white/60 backdrop-blur-sm rounded-lg p-1.5 flex items-center gap-2 border border-gray-100/50">
                                    @if($order->merchantOrder && $order->merchantOrder->driver_name)
                                        <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 text-xs">
                                            <i class="fas fa-motorcycle"></i>
                                        </div>
                                        <div class="flex flex-col overflow-hidden">
                                            <span class="text-[10px] font-bold text-gray-700 truncate">{{ $order->merchantOrder->driver_name }}</span>
                                            <span class="text-[9px] text-gray-400 truncate">{{ $order->merchantOrder->driver_plate ?? 'No Plate' }}</span>
                                        </div>
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 text-xs animate-pulse">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <span class="text-[10px] italic text-gray-400">Finding Driver...</span>
                                    @endif
                                </div>
                                @else
                                <div class="bg-white/60 backdrop-blur-sm rounded-lg p-1.5 flex items-center gap-2 border border-gray-100/50">
                                    <div class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 text-xs">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <span class="text-[10px] font-medium text-gray-600 truncate">{{ $order->table->name ?? 'Take Away' }}</span>
                                </div>
                                @endif
                        </div>

                        {{-- Status Footer --}}
                        <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-200/50 border-dashed relative z-10">
                            <span class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider {{ $statusStyles['text'] }}">
                                <i class="fas {{ $statusStyles['icon'] }} text-[10px]"></i>
                                {{ $statusStyles['label'] }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-mono font-medium">{{ $order->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="h-full flex flex-col items-center justify-center text-gray-400 pb-2">
                @if($activeOrderFilter === 'online')
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-cloud-moon text-xl text-gray-300"></i>
                    </div>
                    <p class="text-xs font-medium">No Active Online Orders</p>
                    <p class="text-[10px] text-gray-300 mt-1">Waiting for incoming orders...</p>
                @elseif($activeOrderFilter === 'dine_in')
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-utensils text-xl text-gray-300"></i>
                    </div>
                    <p class="text-xs font-medium">No Dine In Orders</p>
                @else
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-check text-gray-400"></i>
                    </div>
                    <p class="text-xs text-gray-400">Empty Queue</p>
                @endif
            </div>
        @endif
    </div>
</div>
