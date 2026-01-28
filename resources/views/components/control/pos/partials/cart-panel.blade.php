<div class="fixed inset-0 z-50 bg-white flex flex-col transform transition-transform duration-300 ease-in-out sm:relative sm:translate-y-0 sm:w-80 lg:w-96 sm:border-l sm:border-gray-200 sm:flex-shrink-0 sm:z-0"
        :class="showMobileCart ? 'translate-y-0' : 'translate-y-full'">
    
    {{-- Order Header --}}
    <div class="p-4 border-b border-gray-100">
        {{-- Mobile Close Button --}}
        <div class="flex sm:hidden items-center justify-between mb-4 pb-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-space-100 text-space-600 flex items-center justify-center">
                    <i class="fas fa-receipt"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-900">Current Order</h3>
            </div>
            <button @click="showMobileCart = false" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-500 hover:bg-gray-100">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <i class="fas fa-receipt text-space-600"></i>
                <span class="text-sm font-semibold text-gray-900">{{ $currentOrderNumber }}</span>
            </div>
            @if(count($cartItems) > 0)
                <button wire:click="clearCart" class="text-xs text-red-500 hover:text-red-600 font-medium">
                    <i class="fas fa-trash mr-1"></i>Clear
                </button>
            @endif
        </div>
        
        {{-- Customer Name --}}
        <input type="text" 
                wire:model="customerName" 
                placeholder="Customer's Name" 
                class="w-full text-lg font-semibold text-gray-900 placeholder:text-gray-300 border-none p-0 focus:ring-0 outline-none bg-transparent mb-3">
        
        {{-- Table & Order Type --}}
        <div class="flex gap-2">
            <select wire:model="tableId" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
                <option value="">Select Table</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->name }}</option>
                @endforeach
            </select>
            <select wire:model="orderType" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
                <option value="dine_in">Dine In</option>
                <option value="take_away">Take Away</option>
            </select>
        </div>
    </div>
    
    {{-- Cart Items --}}
    <div class="flex-1 overflow-y-auto p-4 space-y-2">
        @forelse($cartItems as $index => $item)
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl group">
                {{-- Thumbnail --}}
                <div class="w-12 h-12 bg-white rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
                    @if($item['image'])
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fas fa-bowl-food text-sm"></i>
                        </div>
                    @endif
                </div>
                
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h4 class="font-medium text-gray-900 text-sm truncate">{{ $item['name'] }}</h4>
                    <p class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    @if($item['notes'])
                        <p class="text-xs text-space-600 truncate"><i class="fas fa-sticky-note mr-1"></i>{{ $item['notes'] }}</p>
                    @endif
                </div>
                
                {{-- Quantity --}}
                <div class="flex items-center gap-1">
                    <button wire:click="decrementCartItem({{ $index }})" class="w-6 h-6 flex items-center justify-center rounded-md bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-red-500 text-xs">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="w-6 text-center font-medium text-sm">{{ $item['quantity'] }}</span>
                    <button wire:click="incrementCartItem({{ $index }})" class="w-6 h-6 flex items-center justify-center rounded-md bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 hover:text-green-500 text-xs">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                <p class="text-sm">No Item Selected</p>
                <p class="text-xs">Tap product to add</p>
            </div>
        @endforelse
    </div>
    
    {{-- Order Summary --}}
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        {{-- Totals --}}
        <div class="space-y-1.5 mb-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Subtotal</span>
                <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Tax ({{ $taxRate }}%)</span>
                <span class="font-medium">Rp {{ number_format($taxAmount, 0, ',', '.') }}</span>
            </div>
            @if($discountAmount > 0)
                <div class="flex justify-between text-sm text-green-600">
                    <span>Discount</span>
                    <span class="font-medium">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200">
                <span>TOTAL</span>
                <span class="text-space-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
        
        {{-- Payment Method --}}
        <div class="flex gap-2 mb-3">
            <button wire:click="selectPaymentMethod('cash')" class="flex-1 py-2.5 rounded-lg text-sm font-medium transition-all {{ $paymentMethod === 'cash' ? 'bg-green-500 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                <i class="fas fa-money-bill mr-1"></i> Cash
            </button>
            <button wire:click="selectPaymentMethod('qris')" class="flex-1 py-2.5 rounded-lg text-sm font-medium transition-all {{ $paymentMethod === 'qris' ? 'bg-teal-500 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                <i class="fas fa-qrcode mr-1"></i> QRIS
            </button>
        </div>
        
        {{-- Place Order Button --}}
        <button wire:click="placeOrder" 
                class="w-full py-3.5 bg-gradient-to-r from-space-800 to-space-700 hover:from-space-700 hover:to-space-600 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70"
                {{ count($cartItems) == 0 ? 'disabled' : '' }}>
            <span wire:loading.remove wire:target="placeOrder">
                <i class="fas fa-check-circle"></i>
                Place Order
            </span>
            <span wire:loading wire:target="placeOrder">
                <i class="fas fa-spinner fa-spin"></i>
                Processing...
            </span>
        </button>
    </div>
</div>
