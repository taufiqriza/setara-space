<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Dashboard' }} - Setara Space POS</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('storage/logo.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        space: {
                            50: '#eef1ff',
                            100: '#e0e5ff',
                            200: '#c7ceff',
                            300: '#a5acff',
                            400: '#8180ff',
                            500: '#6b5cfa',
                            600: '#5b3def',
                            700: '#4d30db',
                            800: '#3B4CCA',
                            900: '#2d2a8c',
                            950: '#1A1A2E'
                        },
                        golden: {
                            400: '#FBBF24',
                            500: '#F9A825',
                        }
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Hide Alpine elements until initialized */
        [x-cloak] { display: none !important; }
        
        body { font-family: 'Outfit', sans-serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Hide scrollbar but keep functionality */
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        
        /* Page transition loading animation */
        .page-loading {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e5ff 100%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        
        .page-loading .spinner {
            width: 48px;
            height: 48px;
            border: 4px solid #e0e5ff;
            border-top-color: #3B4CCA;
            border-radius: 50%;
            animation: spin 0.8s ease-in-out infinite;
        }
        
        .page-loading .dots {
            display: flex;
            gap: 6px;
        }
        
        .page-loading .dots span {
            width: 10px;
            height: 10px;
            background: #3B4CCA;
            border-radius: 50%;
            animation: bounce 0.6s ease-in-out infinite;
        }
        
        .page-loading .dots span:nth-child(2) { animation-delay: 0.1s; }
        .page-loading .dots span:nth-child(3) { animation-delay: 0.2s; }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(-8px); opacity: 0.6; }
        }
        
        /* Progress bar at top */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #3B4CCA, #6b5cfa, #8180ff);
            z-index: 10000;
            animation: progress 1s ease-out forwards;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        /* Sidebar - Smooth slide animation */
        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .sidebar-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        
        .sidebar-panel {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-panel.open {
            transform: translateX(0);
        }

        /* SweetAlert Customization */
        div:where(.swal2-container) {
            z-index: 99999 !important;
            padding-top: 1rem !important; /* Visual spacing for top aligned alerts */
        }
        
        div:where(.swal2-popup) {
            font-family: 'Outfit', sans-serif !important;
            border-radius: 1rem !important;
        }
        
        div:where(.swal2-title) {
            font-size: 1.25rem !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
        }

        /* Toast Customization */
        .colored-toast.swal2-icon-success {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            border-left: 6px solid #10b981 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        
        .colored-toast.swal2-icon-error {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            border-left: 6px solid #ef4444 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        
        .colored-toast.swal2-icon-warning {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            border-left: 6px solid #f59e0b !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        
        .colored-toast.swal2-icon-info {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            border-left: 6px solid #3B4CCA !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        
        .colored-toast .swal2-title {
            color: #374151 !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
        }
        
        .colored-toast .swal2-close {
            color: #9ca3af !important;
        }
        
        .colored-toast .swal2-html-container {
            color: #6b7280 !important;
            font-size: 0.875rem !important;
        }
    </style>
    
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50 min-h-screen">
    
    {{-- Page Loading Indicator (Livewire Navigate) --}}
    <div wire:loading.delay.long class="page-loading">
        <div class="spinner"></div>
        <p class="text-gray-500 text-sm font-medium">Loading...</p>
    </div>
    
    {{-- Progress Bar --}}
    <div wire:loading.delay class="progress-bar"></div>
    
    {{-- Root Wrapper with Sidebar State --}}
    <div x-data="{ sidebarOpen: false }" 
         @toggle-sidebar.window="sidebarOpen = !sidebarOpen" 
         @close-sidebar.window="sidebarOpen = false"
         class="relative">

        {{-- Sidebar Overlay --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
             @click="sidebarOpen = false"
             x-cloak></div>
    
    {{-- Sidebar Panel --}}
    <aside x-show="sidebarOpen"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed left-0 top-0 bottom-0 w-72 bg-white shadow-2xl z-50 flex flex-col"
           x-cloak>
        
        {{-- User Info --}}
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-space-600 to-space-800 flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->roles->first()->name ?? 'Staff' }}</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('control.pos') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.pos') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               @click="sidebarOpen = false">
                <i class="fas fa-cash-register w-5 text-center"></i>
                <span>Point of Sales</span>
            </a>
            <a href="{{ route('control.activity') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.activity') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               @click="sidebarOpen = false">
                <i class="fas fa-list-alt w-5 text-center"></i>
                <span>Activity</span>
            </a>
            <a href="{{ route('control.report') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.report') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               @click="sidebarOpen = false">
                <i class="fas fa-chart-bar w-5 text-center"></i>
                <span>Report</span>
            </a>
            <a href="{{ route('control.inventory') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.inventory') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               @click="sidebarOpen = false">
                <i class="fas fa-box w-5 text-center"></i>
                <span>Products</span>
            </a>
            <a href="{{ route('control.teams') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.teams') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               @click="sidebarOpen = false">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Teams</span>
            </a>
            <a href="{{ route('control.settings') }}" wire:navigate 
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('control.settings') ? 'bg-space-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
               @click="sidebarOpen = false">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Settings</span>
            </a>
        </nav>
        
        {{-- Logout --}}
        <div class="p-4 border-t border-gray-100">
            <form action="{{ route('control.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="min-h-screen">
        {{ $slot }}
    </main>
    
    {{-- Sidebar Toggle Script --}}
    <script>
        // Bridge for legacy onclick calls to Alpine state
        window.toggleSidebar = function() {
            window.dispatchEvent(new CustomEvent('toggle-sidebar'));
        }
        
        window.openSidebar = function() {
             // Force open if needed, or just toggle
             window.dispatchEvent(new CustomEvent('toggle-sidebar')); 
        }

        window.closeSidebar = function() {
            // We can strictly close by dispatching a specific event or just relying on toggle if we track state.
            // But for now, let's just use the toggle event or access alpine scope if possible.
            // Simpler: Just rely on the click-away in Alpine which sets sidebarOpen = false.
            // But for programmatic close (like nav links), we can dispatch a 'close-sidebar' event.
            window.dispatchEvent(new CustomEvent('close-sidebar'));
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.dispatchEvent(new CustomEvent('close-sidebar'));
            }
        });
    </script>
    
    @livewireScripts
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const SwalModal = (icon, title, html) => {
            Swal.fire({
                icon,
                title,
                html,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast', // You can define custom CSS if needed
                }
            })
        }

        const SwalConfirm = (icon, title, html, confirmButtonText, method, params, callback) => {
            Swal.fire({
                icon,
                title,
                html,
                showCancelButton: true,
                confirmButtonColor: '#4d30db', // space-700
                cancelButtonColor: '#d33',
                confirmButtonText,
                reverseButtons: true,
                backdrop: `rgba(0,0,0,0.4)`
            }).then(result => {
                if (result.isConfirmed) {
                    return Livewire.dispatch(method, params)
                }
            });
        }
        
        // Listen to livewire events
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('swal:modal', (data) => {
                const dataObj = data[0]; // Livewire 3 returns array arguments
                Swal.fire({
                    icon: dataObj.type,
                    title: dataObj.title,
                    text: dataObj.text,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#fff',
                    color: '#1f2937',
                    iconColor: dataObj.type === 'success' ? '#10b981' : '#ef4444',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-gray-100'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    }
                });
            });

            Livewire.on('swal:confirm', (data) => {
                const dataObj = data[0]; 
                Swal.fire({
                    title: dataObj.title,
                    text: dataObj.text,
                    icon: dataObj.type,
                    showCancelButton: true,
                    confirmButtonColor: '#5b3def', // space-600
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl',
                        confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-lg shadow-space-200 transition-transform hover:scale-105',
                        cancelButton: 'rounded-xl px-5 py-2.5 font-bold text-gray-700 hover:bg-gray-100 transition-transform hover:scale-105'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(dataObj.method, { id: dataObj.id });
                    }
                });
            });

            // Compact Centered Notification (Dynamic Island Style)
            Livewire.on('swal:compact', (data) => {
                const dataObj = data[0];
                Swal.fire({
                    html: `<div class="flex items-center gap-3">
                            <span class="${dataObj.type === 'success' ? 'text-green-400' : (dataObj.type === 'error' ? 'text-red-400' : 'text-blue-400')} text-lg">
                                <i class="fas ${dataObj.type === 'success' ? 'fa-check-circle' : (dataObj.type === 'error' ? 'fa-times-circle' : 'fa-info-circle')}"></i>
                            </span>
                            <span class="font-medium text-sm text-white tracking-wide">${dataObj.text}</span>
                           </div>`,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 2000,
                    width: 'auto',
                    padding: '0.5rem 1.25rem',
                    backdrop: false,
                    background: '#1f2937', // Dark gray/almost black
                    customClass: {
                        popup: 'rounded-full shadow-2xl border border-gray-700 flex items-center mt-4', // mt-4 pushes it down slightly
                        htmlContainer: 'm-0 p-0 overflow-visible'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    }
                });
            });
        });

        // Flash Messages compatibility
        @if(session()->has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        @endif

        @if(session()->has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        @endif
    </script>
</body>
</html>
