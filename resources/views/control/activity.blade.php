<x-layouts.control title="Activity">
    <div class="h-screen flex flex-col overflow-hidden">
        {{-- Header --}}
        <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
            <div class="flex items-center gap-4">
                <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-900">Activity</h1>
                <span class="text-gray-400">/</span>
                <span class="text-gray-500">Billing Queue</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <i class="far fa-calendar"></i>
                <span>{{ now()->format('D, d M Y') }}</span>
            </div>
        </header>
        
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hard-hat text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Coming Soon</h2>
                <p class="text-gray-500">Activity page is under development.</p>
                <a href="{{ route('control.pos') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-space-600 text-white rounded-lg hover:bg-space-700 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    Back to POS
                </a>
            </div>
        </div>
    </div>
</x-layouts.control>
