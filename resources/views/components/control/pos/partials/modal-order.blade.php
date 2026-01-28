@if($showOrderDetailModal && $selectedOrder)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" wire:click.stop>
            {{-- Header --}}
            <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <div class="flex flex-col">
                    <h3 class="font-bold text-gray-900 text-lg">{{ $selectedOrder->order_number }}</h3>
                    
                    {{-- Platform Indicator in Header --}}
                    @if(in_array($selectedOrder->payment_method, ['gofood', 'grabfood', 'shopeefood']))
                         <div class="flex items-center gap-1 mt-0.5">
                            @if($selectedOrder->payment_method === 'gofood')
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gofood_logo.svg/200px-Gofood_logo.svg.png" class="h-4 w-auto" alt="GoFood">
                            @else
                                <span class="bg-green-500 text-white text-[10px] px-1.5 py-0.5 rounded font-bold uppercase">{{ $selectedOrder->payment_method }}</span>
                            @endif
                            <span class="text-xs text-gray-500">• {{ $selectedOrder->customer_name }}</span>
                         </div>
                    @else
                         <p class="text-xs text-gray-500">{{ $selectedOrder->customer_name ?: 'Guest' }} • {{ $selectedOrder->table->name ?? 'Take Away' }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-wider
                        {{ $selectedOrder->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $selectedOrder->status === 'on_kitchen' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $selectedOrder->status === 'all_done' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $selectedOrder->status === 'to_be_served' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $selectedOrder->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $selectedOrder->status)) }}
                    </span>
                    <button wire:click="closeOrderDetailModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-400">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            {{-- Order Notes (Important for integration) --}}
            @if($selectedOrder->notes)
                <div class="px-4 py-2 bg-yellow-50 text-xs text-yellow-800 border-b border-yellow-100">
                    <i class="fas fa-comment-alt mr-1"></i> 
                    <strong>Notes:</strong> {{ $selectedOrder->notes }}
                </div>
            @endif

            {{-- Merchant details (Driver) --}}
            @if($selectedOrder->merchantOrder)
                <div class="px-4 py-2 bg-blue-50 text-xs text-blue-800 border-b border-blue-100 flex justify-between items-center">
                    <div>
                        <div class="font-bold flex items-center gap-1">
                            <i class="fas fa-motorcycle"></i>
                            {{ $selectedOrder->merchantOrder->driver_name ?? 'Finding Driver...' }}
                        </div>
                        @if($selectedOrder->merchantOrder->driver_plate)
                            <div class="text-[10px] opacity-75">{{ $selectedOrder->merchantOrder->driver_plate }}</div>
                        @endif
                    </div>
                     <div class="font-mono">{{ $selectedOrder->merchantOrder->booking_id }}</div>
                </div>
            @endif

            {{-- Items --}}
            <div class="p-4 max-h-[250px] overflow-y-auto">
                <div class="space-y-3">
                    @foreach($selectedOrder->items as $item)
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded bg-space-100 text-space-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
                            {{ $item->quantity }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                            @if($item->notes)
                                <p class="text-xs text-red-500 font-medium italic">"{{ $item->notes }}"</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Status Change Actions (Optimized for Online Order) --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-3 text-center">Update Status</p>
                
                <div class="grid grid-cols-2 gap-2">
                    {{-- Logic Status:
                         Pending -> Cooking (Kitchen) -> Ready (Server) -> Done
                         For GoFood: Pending -> Accept -> Ready -> Completed
                    --}}

                    @if($selectedOrder->status === 'pending')
                        <button wire:click="updateOrderStatus('on_kitchen')" class="col-span-2 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl flex items-center justify-center gap-2">
                            <i class="fas fa-fire-burner"></i> 
                            {{ in_array($selectedOrder->payment_method, ['gofood', 'grabfood']) ? 'Accept & Cook' : 'Process to Kitchen' }}
                        </button>
                    
                    @elseif($selectedOrder->status === 'on_kitchen')
                        <button wire:click="updateOrderStatus('to_be_served')" class="col-span-2 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-xl flex items-center justify-center gap-2">
                            <i class="fas fa-bell-concierge"></i>
                             {{ in_array($selectedOrder->payment_method, ['gofood', 'grabfood']) ? 'Ready for Pickup' : 'Order Ready to Serve' }}
                        </button>
                    
                    @elseif($selectedOrder->status === 'to_be_served')
                        <button wire:click="updateOrderStatus('all_done')" class="col-span-2 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl flex items-center justify-center gap-2">
                            <i class="fas fa-check-double"></i> Complete Order
                        </button>
                    @endif
                </div>
                
                <div class="mt-2 text-center">
                    <span class="text-xs text-gray-400">Current Status: {{ ucfirst(str_replace('_', ' ', $selectedOrder->status)) }}</span>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Store Status Modal (Simple enough to keep embedded or separate, separation is better) --}}
@if($showStoreStatusModal)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" wire:click.stop>
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 {{ $storeStatus === 'open' ? 'bg-red-100 text-red-500' : 'bg-green-100 text-green-500' }}">
                    <i class="fas {{ $storeStatus === 'open' ? 'fa-store-slash' : 'fa-store' }} text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">
                    {{ $storeStatus === 'open' ? 'Close the Store?' : 'Open the Store?' }}
                </h3>
                <p class="text-sm text-gray-500 mb-6">
                    {{ $storeStatus === 'open' 
                        ? 'This will mark the store as closed. Are you sure?' 
                        : 'This will mark the store as open. Ready to serve?' }}
                </p>
                
                <div class="flex gap-3">
                    <button wire:click="closeStoreStatusModal" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button wire:click="toggleStoreStatus" 
                            class="flex-1 py-2.5 font-medium rounded-xl text-white shadow-lg transition-all transform hover:scale-105 {{ $storeStatus === 'open' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                        {{ $storeStatus === 'open' ? 'Close Store' : 'Open Store' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
