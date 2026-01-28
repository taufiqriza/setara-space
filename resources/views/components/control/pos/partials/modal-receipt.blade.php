@if($showReceiptModal && $lastOrder)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-6" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden flex flex-col max-h-[90vh]" wire:click.stop>
            {{-- Header --}}
            <div class="p-6 text-center border-b border-dashed border-gray-300 bg-gray-50 flex-shrink-0">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 animate-bounce">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900">Order Success!</h3>
                <p class="text-gray-500 text-sm font-mono mt-1">{{ $lastOrder['order_number'] }}</p>
            </div>
            
            {{-- Receipt Preview (Scrollable) --}}
            <div class="overflow-y-auto p-6 bg-white" id="receiptContentPos">
                {{-- Thermal Printer Layout --}}
                <div class="font-mono text-xs leading-relaxed text-gray-900" style="font-family: 'Courier New', Courier, monospace;">
                    <div class="text-center mb-4">
                        <h2 class="font-extrabold text-base uppercase">Setara Space</h2>
                        <p class="text-[10px] text-gray-500">Jl. Soekarno Hatta No. 10</p>
                        <p class="text-[10px] text-gray-500">Malang, Jawa Timur</p>
                    </div>

                    <div class="border-b border-dashed border-gray-400 pb-2 mb-2">
                            <div class="flex justify-between">
                            <span>Date:</span>
                            <span>{{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Order:</span>
                            <span>{{ $lastOrder['order_number'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Cashier:</span>
                            <span>{{ auth()->user()->name ?? 'Staff' }}</span>
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="border-b border-dashed border-gray-400 pb-2 mb-2 space-y-1">
                            @foreach($lastOrder['items'] as $item)
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div>{{ $item['name'] }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $item['quantity'] }} x {{ number_format($item['subtotal'] / $item['quantity'], 0, ',', '.') }}</div>
                                </div>
                                <div class="font-bold">{{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="space-y-1 mb-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>{{ number_format($lastOrder['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        @if($lastOrder['tax_amount'] > 0)
                        <div class="flex justify-between">
                            <span>Tax</span>
                            <span>{{ number_format($lastOrder['tax_amount'], 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between font-bold text-sm border-t border-dashed border-gray-400 pt-1 mt-1">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($lastOrder['total'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[10px] text-gray-500 mt-1">
                            <span>Payment</span>
                            <span class="uppercase">{{ $lastOrder['payment_method'] }}</span>
                        </div>
                    </div>

                    <div class="text-center text-[10px] mt-4 pt-2 border-t border-dashed border-gray-400">
                        <p>Thank you for your visit!</p>
                        <p>Please come again.</p>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50 flex gap-3 flex-shrink-0">
                <button wire:click="closeReceiptModal" class="flex-1 py-3 text-gray-600 font-medium hover:bg-gray-200 rounded-xl transition-colors">
                    Close
                </button>
                <button onclick="printReceiptPos('receiptContentPos')" class="flex-[2] py-3 bg-space-800 hover:bg-space-900 text-white font-bold rounded-xl flex items-center justify-center gap-2 transition-transform active:scale-95 shadow-lg">
                    <i class="fas fa-print"></i> Print Receipt（Global)
                </button>
            </div>
        </div>
    </div>
@endif
