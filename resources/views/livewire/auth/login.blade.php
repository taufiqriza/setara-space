<div class="w-full max-w-md relative z-10">
    <!-- Login Card -->
    <div class="glass rounded-3xl shadow-2xl p-8 sm:p-10">
        
        <!-- Logo & Brand -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden shadow-lg shadow-space-800/30">
                <img src="{{ asset('storage/logo.jpeg') }}" alt="Setara Space" class="w-full h-full object-cover">
            </div>
            <h1 class="text-2xl font-bold text-space-800">Setara Space</h1>
            <p class="text-space-500 text-sm mt-1">
                <i class="fas fa-globe text-golden-500"></i> 
                Point of Sale System
            </p>
        </div>
        
        <!-- Login Form -->
        <form wire:submit="login" class="space-y-5">
            
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-space-700 mb-2">
                    <i class="fas fa-envelope text-space-400 mr-1"></i> Email
                </label>
                <input 
                    type="email" 
                    wire:model="email"
                    placeholder="admin@setaraspace.id"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-500/20 outline-none transition-all duration-200 text-space-800 placeholder:text-gray-400"
                    autofocus
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            
            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-space-700 mb-2">
                    <i class="fas fa-lock text-space-400 mr-1"></i> Password
                </label>
                <div class="relative" x-data="{ show: false }">
                    <input 
                        :type="show ? 'text' : 'password'"
                        wire:model="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-500/20 outline-none transition-all duration-200 text-space-800 placeholder:text-gray-400"
                    >
                    <button 
                        type="button"
                        @click="show = !show"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-space-600 transition-colors"
                    >
                        <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            
            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input 
                        type="checkbox" 
                        wire:model="remember"
                        class="w-4 h-4 rounded border-gray-300 text-space-600 focus:ring-space-500"
                    >
                    <span class="text-sm text-space-600 group-hover:text-space-800 transition-colors">Ingat saya</span>
                </label>
            </div>
            
            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full py-3.5 bg-gradient-to-r from-space-800 to-space-700 hover:from-space-700 hover:to-space-600 text-white font-semibold rounded-xl shadow-lg shadow-space-800/30 hover:shadow-xl hover:shadow-space-800/40 transition-all duration-300 flex items-center justify-center gap-2 group"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70 cursor-not-allowed"
            >
                <span wire:loading.remove>
                    <i class="fas fa-sign-in-alt group-hover:translate-x-1 transition-transform"></i>
                    Masuk ke Dashboard
                </span>
                <span wire:loading class="flex items-center gap-2">
                    <i class="fas fa-spinner fa-spin"></i>
                    Memproses...
                </span>
            </button>
        </form>
        
        <!-- Footer Info -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
                &copy; {{ date('Y') }} Setara Space - Dimsum Homemade
            </p>
            <p class="text-xs text-gray-400 mt-1">
                <i class="fas fa-shield-alt text-green-500"></i> 
                Secure Login with SSL
            </p>
        </div>
    </div>
    
    <!-- Back to Home Link -->
    <div class="text-center mt-6">
        <a href="/" class="text-white/80 hover:text-white text-sm transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Beranda
        </a>
    </div>
</div>
