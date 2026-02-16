<x-app-layout>
    <audio id="bgMusic" loop preload="auto">
        <source src="{{ asset('audio/ultahmeira.mp3') }}" type="audio/mpeg">
    </audio>

    <div class="py-12 bg-indigo-50 min-h-screen flex flex-col items-center justify-center">
        <h2 class="text-3xl font-bold mb-6 text-indigo-600">Our Best Memories ❤️</h2>
        <div class="swiper mySwiper max-w-xl w-full rounded-2xl shadow-2xl overflow-hidden">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{ asset('img/memory1.jpg') }}" class="w-full h-96 object-cover"></div>
                </div>
        </div>
        <a href="{{ route('birthday.cake') }}" class="mt-10 bg-pink-500 text-white px-10 py-4 rounded-full font-bold">Lanjut... ➡️</a>
    </div>

    <script>
        const audio = document.getElementById('bgMusic');

        window.addEventListener('load', () => {
            const savedTime = localStorage.getItem('audioTime');
            if (savedTime) audio.currentTime = parseFloat(savedTime);
            audio.play();
        });

        audio.addEventListener('timeupdate', () => {
            localStorage.setItem('audioTime', audio.currentTime);
        });

        document.querySelector('a').addEventListener('click', () => {
            localStorage.setItem('audioTime', audio.currentTime);
        });
    </script>
</x-app-layout>