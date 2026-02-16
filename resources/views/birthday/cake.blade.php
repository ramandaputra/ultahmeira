<x-app-layout>
    <audio id="bgMusic" loop>
        <source src="{{ asset('audio/ultahmeira.mp3') }}" type="audio/mpeg">
    </audio>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <style>
        .flame {
            width: 20px; height: 30px; background: orange; border-radius: 50%;
            position: absolute; top: -25px; left: 50%; transform: translateX(-50%);
            box-shadow: 0 0 20px yellow; animation: flicker 0.1s infinite alternate;
        }
        @keyframes flicker { from { opacity: 0.8; } to { opacity: 1; } }
        .hidden { display: none; }
    </style>

    <div class="py-12 bg-pink-50 min-h-screen flex flex-col items-center justify-center text-center">
        
        <div id="cake-section">
            <h2 class="text-4xl font-black text-pink-600 mb-10">Make a Wish! 🎂</h2>
            
            <div class="relative inline-block mb-10">
                <img src="{{ asset('img/cake.png') }}" class="w-72 mx-auto">
                <div id="api-lilin" class="flame"></div>
            </div>

            <br>
            <button onclick="tiupLilin()" id="btn-tiup" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 px-12 py-5 rounded-full font-extrabold text-2xl shadow-2xl transition-transform active:scale-95">
                TIUP LILINNYA! 🌬️
            </button>
        </div>

        <div id="card-section" class="hidden px-4">
            <div class="bg-white p-8 rounded-3xl shadow-2xl border-4 border-pink-200 max-w-md mx-auto">
                <img src="{{ asset('img/foto-utama.jpg') }}" class="w-32 h-32 mx-auto rounded-full border-4 border-pink-400 mb-4 object-cover">
                <h1 class="text-3xl font-black text-pink-600 mb-4">HAPPY BIRTHDAY! 🎉</h1>
                <p class="text-gray-600 leading-relaxed italic">
                    "Semoga harimu luar biasa! Terima kasih sudah mampir ke sini..."
                </p>

                <div class="mt-10 border-t pt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" onclick="clearMusic()" class="text-gray-500 hover:text-pink-600 font-medium transition-colors flex items-center justify-center mx-auto gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Selesai & Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const audio = document.getElementById('bgMusic');

        // --- LOGIKA AUDIO SEAMLESS ---

        // 1. Sinkronisasi Audio saat halaman dimuat
        window.addEventListener('load', () => {
            const savedTime = localStorage.getItem('audioTime');
            if (savedTime) {
                audio.currentTime = parseFloat(savedTime);
            }
            
            // Lanjutkan pemutaran
            audio.play().catch(() => console.log("Menunggu klik user untuk memutar audio"));
        });

        // 2. Simpan waktu secara rutin (setiap 0.5 detik)
        setInterval(() => {
            if (!audio.paused) {
                localStorage.setItem('audioTime', audio.currentTime);
            }
        }, 500);

        // 3. Fungsi hapus data saat logout (reset dari nol untuk kunjungan berikutnya)
        function clearMusic() {
            localStorage.removeItem('audioTime');
            localStorage.removeItem('playMusic');
        }

        // --- LOGIKA INTERAKSI HALAMAN ---

        function tiupLilin() {
            // Animasi Matikan Api
            document.getElementById('api-lilin').style.display = 'none';
            document.getElementById('btn-tiup').style.display = 'none';
            
            // Efek Confetti
            confetti({ 
                particleCount: 200, 
                spread: 90, 
                origin: { y: 0.7 },
                colors: ['#ec4899', '#f472b6', '#fbcfe8', '#fbbf24']
            });

            // Munculkan Card Setelah 1 Detik
            setTimeout(() => {
                document.getElementById('cake-section').classList.add('hidden');
                document.getElementById('card-section').classList.remove('hidden');
            }, 1000);
        }

        // Backup: Klik di mana saja untuk memastikan audio menyala
        document.addEventListener('click', () => {
            if (audio.paused) { audio.play(); }
        }, { once: true });
    </script>
</x-app-layout>