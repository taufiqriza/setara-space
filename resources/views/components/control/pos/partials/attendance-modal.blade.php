@props(['show' => false, 'type' => 'start', 'expectedCash' => 0])

<div
    x-data="{ 
        // Inisialisasi awal dari server state (One-Way saat load)
        show: {{ $show ? 'true' : 'false' }},
        photo: null,
        
        init() {
            // Jika show true saat load, nyalakan kamera
            if(this.show) {
                this.$nextTick(() => window.AttendanceCamera.init());
            }

            // Listen to browser events
            window.addEventListener('open-attendance-modal', () => {
                this.show = true;
                this.$nextTick(() => window.AttendanceCamera.init());
            });

            window.addEventListener('close-attendance-modal', () => {
                window.AttendanceCamera.stop();
                this.show = false;
                this.photo = null;
            });
        },

        capturePhoto() {
            const dataUrl = window.AttendanceCamera.captureResult();
            if(dataUrl) {
                this.photo = dataUrl;
                // Kirim ke Livewire manual agar pasti masuk
                @this.set('tempPhoto', dataUrl);
            }
        },

        retakePhoto() {
            this.photo = null;
            // @this.set('tempPhoto', null); // Tidak wajib sync null ke server, cukup lokal
            window.AttendanceCamera.restart();
        }
    }"
    x-show="show"
    x-cloak
    class="relative z-[100]"
    style="display: none;"
>
    <!-- Overlay -->
    <div class="fixed inset-0 bg-space-950/90 backdrop-blur-xl transition-opacity"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            
            <div class="relative w-full max-w-md transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-white/20">
                 
                <!-- Header -->
                <div class="h-32 bg-gradient-to-br {{ $type === 'start' ? 'from-indigo-600 to-blue-500' : 'from-rose-600 to-orange-500' }} relative overflow-hidden flex flex-col justify-center items-center text-white shrink-0">
                     <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
                     <div class="relative z-10 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto mb-2 text-2xl shadow-lg border border-white/30">
                            @if($type === 'start') <i class="fas fa-door-open"></i> @else <i class="fas fa-door-closed"></i> @endif
                        </div>
                        <h2 class="text-xl font-bold tracking-tight">{{ $type === 'start' ? 'Buka Kasir' : 'Tutup Kasir' }}</h2>
                        <p class="text-xs text-white/80 font-medium mt-1">{{ $type === 'start' ? 'Verifikasi Kehadiran & Modal Awal' : 'Rekonsiliasi Uang & Selesaikan Shift' }}</p>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-6 py-6 -mt-6 relative z-20 bg-white rounded-t-3xl">
                    
                    <!-- Camera Area -->
                    <div wire:ignore class="mb-6 relative group rounded-2xl overflow-hidden shadow-lg bg-gray-900 border-4 border-white aspect-[4/3]">
                        <video id="camera-feed" class="w-full h-full object-cover transform -scale-x-100 bg-black" autoplay playsinline muted></video>
                        <canvas id="camera-canvas" class="hidden"></canvas>
                        
                        <!-- Preview Image -->
                        <img x-show="photo" :src="photo" class="absolute inset-0 w-full h-full object-cover z-40 transform" style="display: none;">
                        
                        <!-- Loading State -->
                        <div id="camera-loading" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-gray-900 z-30">
                            <i class="fas fa-circle-notch fa-spin text-3xl text-indigo-500 mb-3"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider">Menyiapkan Kamera...</span>
                            <span id="camera-error-msg" class="text-[10px] text-red-500 mt-2 px-4 text-center"></span>
                        </div>
                        
                        <!-- Retake Button -->
                        <div x-show="photo" class="absolute bottom-4 inset-x-0 flex justify-center z-[60]">
                           <button type="button" @click="retakePhoto()" class="px-4 py-2 rounded-full bg-gray-900/80 text-white text-xs font-bold backdrop-blur-md shadow-lg border border-white/10"><i class="fas fa-camera-rotate mr-1"></i> Foto Ulang</button>
                        </div>
                    </div>

                    <!-- Input Form -->
                    <div class="space-y-4">
                        @if($type === 'start')
                           <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                               <label class="block text-[10px] font-bold uppercase text-indigo-400 tracking-wider mb-2">Modal Awal Kasir</label>
                               <div class="relative">
                                   <span class="absolute left-0 top-1/2 -translate-y-1/2 font-black text-indigo-300 pl-3">Rp</span>
                                   <input type="number" wire:model.blur="shiftAmount" class="w-full bg-white border-none rounded-lg py-2.5 pl-10 pr-3 font-bold text-gray-800 focus:ring-2 focus:ring-indigo-500 h-10 text-sm shadow-sm" placeholder="0">
                               </div>
                               @error('shiftAmount') <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span> @enderror
                           </div>
                        @else
                           <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                               <label class="block text-[10px] font-bold uppercase text-orange-400 tracking-wider mb-2">Uang Fisik di Laci</label>
                               <div class="relative">
                                   <span class="absolute left-0 top-1/2 -translate-y-1/2 font-black text-orange-300 pl-3">Rp</span>
                                   <input type="number" wire:model.blur="shiftAmount" class="w-full bg-white border-none rounded-lg py-2.5 pl-10 pr-3 font-bold text-gray-800 focus:ring-2 focus:ring-orange-500 h-10 text-sm shadow-sm" placeholder="Hitung...">
                               </div>
                               @error('shiftAmount') <span class="text-red-500 text-[10px] mt-1 block font-bold">{{ $message }}</span> @enderror
                           </div>
                           <textarea wire:model.blur="shiftNotes" rows="2" class="w-full bg-gray-50 border-none rounded-xl text-xs text-gray-600 p-3" placeholder="Catatan..."></textarea>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 pb-6 pt-2 bg-white">
                    <button type="button" 
                            x-show="!photo"
                            @click="capturePhoto()"
                            class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:-translate-y-1 bg-gradient-to-r {{ $type === 'start' ? 'from-indigo-600 to-blue-600' : 'from-rose-600 to-orange-600' }}">
                        <i class="fas fa-camera mr-1"></i> Ambil Foto Wajah
                    </button>

                    <button type="button" 
                            x-show="photo"
                            @if($type === 'start') wire:click="startRegisterShift" @else wire:click="closeRegisterShift" @endif
                            wire:loading.attr="disabled"
                            class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-lg transition-all hover:-translate-y-1 bg-gradient-to-r {{ $type === 'start' ? 'from-indigo-600 to-blue-600' : 'from-rose-600 to-orange-600' }}">
                        <span wire:loading.remove>{{ $type === 'start' ? 'Buka Register' : 'Tutup Register' }} <i class="fas fa-arrow-right ml-1"></i></span>
                        <span wire:loading><i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...</span>
                    </button>
                    
                    @if($type === 'end') <button @click="show = false; window.AttendanceCamera.stop()" class="w-full mt-3 py-2 text-xs font-bold text-gray-400">Batal</button> @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Ensure Global Scope
    window.AttendanceCamera = {
        video: null,
        stream: null,
        loadingEl: null,
        errorEl: null,
        
        init: function(attempts = 0) {
            this.video = document.getElementById('camera-feed');
            this.loadingEl = document.getElementById('camera-loading');
            this.errorEl = document.getElementById('camera-error-msg');
            
            if (!this.video) {
                if (attempts < 20) { 
                    setTimeout(() => this.init(attempts + 1), 100);
                } 
                return;
            }

            if(this.loadingEl) this.loadingEl.style.display = 'flex';
            
            // Check active stream
            if (this.stream && this.stream.active && this.video.srcObject) {
                 this.video.play().catch(e => console.log(e));
                 if(this.loadingEl) this.loadingEl.style.display = 'none';
                 return;
            }

            this.startStream();
        },

        startStream: async function() {
            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    throw new Error("Browser tidak support/HTTPS required");
                }

                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: { width: { ideal: 640 }, height: { ideal: 480 }, facingMode: 'user' },
                    audio: false
                }); 
                
                this.video.srcObject = this.stream;
                
                this.video.onloadedmetadata = () => {
                    this.video.play().then(() => {
                        if(this.loadingEl) this.loadingEl.style.display = 'none';
                    }).catch(e => {
                        setTimeout(() => this.video.play(), 500);
                    });
                };
            } catch (err) {
                console.error("Cam Error", err);
                if(this.errorEl) this.errorEl.innerText = "Gagal: " + err.message + ". Pastikan izin kamera diberikan.";
            }
        },

        stop: function() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            if(this.video) this.video.srcObject = null;
        },

        captureResult: function() {
            if (!this.video || this.video.readyState < 2) return null;
            const canvas = document.getElementById('camera-canvas');
            if(!canvas) return null;

            canvas.width = this.video.videoWidth;
            canvas.height = this.video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(this.video, 0, 0, canvas.width, canvas.height);
            return canvas.toDataURL('image/jpeg', 0.8); // Kompresi 0.8 untuk hemat bandwidth
        },
        
        restart: function() {
            if(this.video) this.video.play();
        }
    };
</script>
