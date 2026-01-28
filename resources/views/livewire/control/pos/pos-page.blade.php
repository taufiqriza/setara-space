<div class="h-screen flex flex-col overflow-hidden" x-data="{ showMobileCart: false }">
    {{-- Header Bar --}}
    @include('components.control.pos.partials.header')
    
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mx-4 mt-2 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mx-4 mt-2 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded-xl flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Content --}}
    <div class="flex-1 flex overflow-hidden">
        {{-- LEFT: Product Grid --}}
        @include('components.control.pos.partials.product-grid')
        
        {{-- RIGHT: Order Panel --}}
        @include('components.control.pos.partials.cart-panel')
    </div>
    
    {{-- Track Order Bar (Bottom) --}}
    @include('components.control.pos.partials.active-orders')
    
    {{-- Modals --}}
    @include('components.control.pos.partials.modal-product')
    @include('components.control.pos.partials.modal-receipt')
    {{-- Modals --}}
    @include('components.control.pos.partials.modal-product')
    @include('components.control.pos.partials.modal-receipt')
    @include('components.control.pos.partials.modal-order')
    
    {{-- Shift Attendance Modal --}}
    @include('components.control.pos.partials.attendance-modal', [
        'show' => $showAttendanceModal, 
        'type' => $attendanceType,
        'expectedCash' => $expectedCash
    ])

    {{-- Global Print Script (Outside Livewire Updates) --}}
    <script>
        // Bind POS Header Printer Button
        document.addEventListener('DOMContentLoaded', () => {
            const posBtn = document.getElementById('posPrinterBtn');
            const posIcon = document.getElementById('posPrinterIcon');
            const posText = document.getElementById('posPrinterText');
    
            if(posBtn) {
                // Cek status awal (in case sudah konek dari sesi sebelumnya/reload)
                if(window.printerManager && window.printerManager.isConnected) {
                     updatePosPrinterUI(true, window.printerManager.device?.name);
                }
    
                posBtn.addEventListener('click', async () => {
                    if (window.printerManager) {
                         if (window.printerManager.isConnected) {
                            // Test print jika sudah connect
                            await window.printerManager.printTest();
                        } else {
                            const connected = await window.printerManager.connect();
                            // UI update akan dihandle oleh event listener global di bawah
                        }
                    } else {
                        alert('Printer Manager not loaded properly.');
                    }
                });
            }
    
            // Listen to global events to sync UI
            window.addEventListener('printer-connected', (e) => {
                updatePosPrinterUI(true, e.detail?.name);
            });
    
            window.addEventListener('printer-disconnected', () => {
                updatePosPrinterUI(false);
            });
    
            function updatePosPrinterUI(connected, name = '') {
                if(!posBtn || !posIcon || !posText) return;
                
                if(connected) {
                    posBtn.className = "flex items-center gap-2 text-xs sm:text-sm font-medium px-2 py-1.5 sm:px-3 sm:py-1.5 rounded-lg transition-colors cursor-pointer bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 mr-2";
                    posIcon.className = "fas fa-print animate-pulse";
                    posText.textContent = name || "Printer Ready";
                } else {
                    posBtn.className = "flex items-center gap-2 text-xs sm:text-sm font-medium px-2 py-1.5 sm:px-3 sm:py-1.5 rounded-lg transition-colors cursor-pointer bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-200 mr-2";
                    posIcon.className = "fas fa-print";
                    posText.textContent = "Connect Printer";
                }
            }
        });
    
        // Existing Global Print Function
        window.printReceiptPos = function(elementId) {
            // Cek dulu apakah printer bluetooth connected & user mau pake itu?
            // Untuk sekarang kita Default ke Browser Print (Stabil), 
            // tapi jika user tekan tombol print, kita bisa kasih opsi atau auto switch.
            // Implementasi 'Hybrid': Coba print ke bluetooth dulu, kalo gagal/gak ada, baru popup window.
            
            if (window.printerManager && window.printerManager.isConnected) {
                 // Logic print ke bluetooth (butuh parsing HTML ke Text/ESC-POS)
                 // Karena parsing HTML ke ESC/POS itu kompleks (butuh library canvas/image), 
                 // SEMENTARA ini kita pakai Browser Print dulu agar 100% works layoutnya.
                 // Print Bluetooth hanya dipakai untuk Test Print via tombol Header dulu.
            }
    
            const contentDiv = document.getElementById(elementId);
            if (!contentDiv) {
                console.error('Receipt content not found:', elementId);
                return;
            }
            // ... rest of the function ...
    
    
            const content = contentDiv.innerHTML;
            const printWindow = window.open('', '', 'width=400,height=600');
            
            if (!printWindow) {
                alert('Please allow popups for this website');
                return;
            }
    
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print Receipt</title>
                        <style>
                            @media print {
                                @page { margin: 0; size: 58mm auto; }
                                body { margin: 0; padding: 5px; width: 58mm; }
                            }
                            body {
                                font-family: 'Courier New', Courier, monospace;
                                font-size: 11px;
                                color: #000;
                                background: #fff;
                                width: 58mm; /* Screen preview width */
                                margin: 0 auto;
                            }
                            .text-center { text-align: center; }
                            .text-right { text-align: right; }
                            .font-bold { font-weight: bold; }
                            .uppercase { text-transform: uppercase; }
                            .flex { display: flex; justify-content: space-between; }
                            .border-b { border-bottom: 1px dashed #000; margin-bottom: 5px; padding-bottom: 5px; }
                            .border-t { border-top: 1px dashed #000; margin-top: 5px; padding-top: 5px; }
                            .mb-2 { margin-bottom: 8px; }
                            .mb-4 { margin-bottom: 12px; }
                            .text-xs { font-size: 10px; }
                            /* Tailwind overrides for print */
                            .text-gray-500 { color: #000; }
                            .text-green-600 { color: #000; }
                        </style>
                    </head>
                    <body>
                        ${content}
                        <script>
                            setTimeout(() => {
                                window.print();
                                 // Auto close after print dialog closes (some browsers)
                                 // or immediately, let user deal with connection
                                 window.close();
                            }, 500);
                        <\/script>
                    </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
</div>
