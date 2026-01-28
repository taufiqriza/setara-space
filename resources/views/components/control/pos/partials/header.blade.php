<header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
    {{-- Left: Menu & Date & Cashier --}}
    <div class="flex items-center gap-3">
        <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
            <i class="fas fa-bars"></i>
        </button>
        <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg">
            <i class="far fa-calendar"></i>
            <span>{{ now()->format('D, d M Y') }}</span>
        </div>
        
        {{-- Mobile Cashier Name --}}
        <div class="flex sm:hidden flex-col">
            <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Kasir</span>
            <span class="text-xs font-bold text-gray-700 truncate max-w-[100px]">{{ auth()->user()->name ?? 'Staff' }}</span>
        </div>

        <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
            <i class="fas fa-user-circle"></i>
            <span>{{ auth()->user()->name ?? 'Kasir' }}</span>
        </div>
    </div>
    
    {{-- Center: Spacer --}}
    <div class="flex-1"></div>
    
    {{-- Right: Status & Time & Refresh --}}
    <div class="flex items-center gap-3">
        {{-- Printer Connect --}}
        <button id="posPrinterBtn" class="flex items-center gap-2 text-xs sm:text-sm font-medium px-2 py-1.5 sm:px-3 sm:py-1.5 rounded-lg transition-colors cursor-pointer bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-200 mr-2">
            <i id="posPrinterIcon" class="fas fa-print"></i>
            <span id="posPrinterText" class="hidden sm:inline">Connect Printer</span>
        </button>
        
        {{-- Store Status --}}
            <button wire:click="openStoreStatusModal" 
                class="flex items-center gap-2 text-xs sm:text-sm font-medium px-2 py-1.5 sm:px-3 sm:py-1.5 rounded-lg transition-colors cursor-pointer {{ $storeStatus === 'open' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                <span class="w-2 h-2 rounded-full {{ $storeStatus === 'open' ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                <span class="hidden sm:inline">{{ $storeStatus === 'open' ? 'Open' : 'Closed' }}</span>
                <span class="sm:hidden">{{ $storeStatus === 'open' ? 'Open' : 'Close' }}</span>
            </button>

            {{-- Shift Status --}}
            @if(!empty($shiftData))
                <button wire:click="initiateCloseRegister" title="Close Register / End Shift"
                        class="flex items-center gap-2 text-xs sm:text-sm font-medium px-2 py-1.5 sm:px-3 sm:py-1.5 rounded-lg transition-colors cursor-pointer bg-purple-100 text-purple-700 hover:bg-purple-200 border border-purple-200">
                    <i class="fas fa-door-closed"></i>
                </button>
            @endif

        <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
            <i class="far fa-clock"></i>
            <span x-data="{ time: '' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}), 1000)" x-text="time"></span>
        </div>
        <button wire:click="$refresh" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-500 transition-colors">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
</header>
