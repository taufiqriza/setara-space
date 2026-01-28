@if($showProductModal && $selectedProduct)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden max-h-[85vh] flex flex-col" wire:click.stop>
            {{-- Close Button --}}
            <div class="flex justify-between items-center p-4 border-b border-gray-100 flex-shrink-0">
                <span class="font-semibold text-gray-900">Detail Menu</span>
                <button wire:click="closeProductModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-y-auto">
                {{-- Product Image --}}
                <div class="aspect-video bg-gray-100 overflow-hidden">
                    @if($selectedProduct['image'])
                        <img src="{{ asset('storage/' . $selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fas fa-bowl-food text-5xl"></i>
                        </div>
                    @endif
                </div>
                
                {{-- Product Info --}}
                <div class="p-4">
                    <span class="text-xs text-space-600 bg-space-50 px-2 py-0.5 rounded-full">{{ $selectedProduct['category'] }}</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $selectedProduct['name'] }}</h3>
                    @if($selectedProduct['description'])
                        <p class="text-sm text-gray-500 mt-1">{{ $selectedProduct['description'] }}</p>
                    @endif
                    <p class="text-2xl font-bold text-space-600 mt-3">Rp {{ number_format($selectedProduct['price'], 0, ',', '.') }}</p>
                    
                    {{-- Notes --}}
                    <div class="mt-4">
                        <label class="text-xs text-gray-500 font-medium mb-1 block">Notes (optional)</label>
                        <textarea wire:model="modalNotes" placeholder="Add notes to your order..." rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none resize-none"></textarea>
                    </div>
                    
                    {{-- Quantity --}}
                    <div class="flex items-center justify-center gap-4 mt-4 py-3 bg-gray-50 rounded-xl">
                        <button wire:click="decrementModalQty" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="text-2xl font-bold w-12 text-center">{{ $modalQuantity }}</span>
                        <button wire:click="incrementModalQty" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Add to Cart Button - Fixed at bottom --}}
            <div class="p-4 bg-gray-50 border-t border-gray-100 flex-shrink-0">
                <button wire:click="addToCart" class="w-full py-3.5 bg-gradient-to-r from-space-800 to-space-700 hover:from-space-700 hover:to-space-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                    <i class="fas fa-cart-plus mr-2"></i>
                    Add to Cart - Rp {{ number_format($selectedProduct['price'] * $modalQuantity, 0, ',', '.') }}
                </button>
            </div>
        </div>
    </div>
@endif
