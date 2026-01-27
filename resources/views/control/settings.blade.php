<x-layouts.control title="Settings">
    <div class="h-screen flex flex-col overflow-hidden">
        <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
            <div class="flex items-center gap-4">
                <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-900">Settings</h1>
            </div>
        </header>
        
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cog text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Coming Soon</h2>
                <p class="text-gray-500">Settings page is under development.</p>
            </div>
        </div>
    </div>
</x-layouts.control>
