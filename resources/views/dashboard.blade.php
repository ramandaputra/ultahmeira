<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <audio id="bgMusic" loop preload="auto">
        <source src="{{ asset('audio/ultahmeira.mp3') }}" type="audio/mpeg">
    </audio>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }

        body {
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            color: #333;
            overflow-x: hidden;
            scroll-behavior: auto;
        }

        section {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
        }

        #hero-section {
            flex-direction: column;
            text-align: center;
        }

        .glass-card {
            background: #ffffff;
            border-radius: 60px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.15);
            width: 1350px;
            max-width: 100%;
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .glass-card h1 { font-weight: 800; font-size: 2.2rem; margin-bottom: 15px; color: #333; text-transform: uppercase; padding: 0 20px; }
        .subtitle { font-size: 18px; color: #666; margin-bottom: 50px; padding: 0 20px; }

        /* QUIZ SCROLL */
        .quiz-scroll {
            display: flex;
            gap: 30px;
            overflow-x: auto;
            padding: 20px 60px 50px;
            justify-content: flex-start;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        @media (min-width: 1300px) { .quiz-scroll { justify-content: center; } }
        .quiz-scroll::-webkit-scrollbar { display: none; }

        .quiz-item {
            flex: 0 0 220px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .quiz-item img {
            width: 200px; height: 200px; object-fit: cover;
            border-radius: 45px; border: 8px solid #f0f0f0;
            margin-bottom: 15px; transition: 0.3s;
        }

        .quiz-item.selected img {
            border-color: #512da8;
            transform: translateY(-15px) scale(1.05);
            box-shadow: 0 20px 35px rgba(81, 45, 168, 0.2);
        }

        /* CAROUSEL */
        .swiper-container-wrapper { width: 100%; margin: 10px 0; overflow: hidden; }
        .mySwiper .swiper-wrapper { transition-timing-function: linear !important; will-change: transform; }
        .swiper-slide { width: 220px; }
        .swiper-slide img {
            width: 100%; height: 300px; object-fit: cover;
            border-radius: 30px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* UI ELEMENTS */
        .hero-text h1 { font-size: 3.5rem; font-weight: 800; letter-spacing: -2px; margin-bottom: 15px; }
        .hero-text p { font-size: 1.2rem; margin-bottom: 35px; color: #555; }

        .btn-main {
            background-color: #512da8; color: #fff; padding: 18px 60px;
            border: none; border-radius: 16px; font-weight: 600; font-size: 14px;
            text-transform: uppercase; letter-spacing: 2px; cursor: pointer; transition: 0.3s;
        }
        .btn-main:hover { background-color: #3f2287; transform: translateY(-5px); }

        .flame {
            width: 14px; height: 24px; background: #ff9800; border-radius: 50%;
            position: absolute; top: -25px; left: 50%; transform: translateX(-50%);
            box-shadow: 0 0 15px #ffeb3b; animation: flicker 0.1s infinite alternate;
        }
        @keyframes flicker { from { opacity: 0.8; transform: translateX(-50%) scale(0.9); } to { opacity: 1; transform: translateX(-50%) scale(1.1); } }

        .reveal { opacity: 0; transform: translateY(50px); transition: 1s ease-out all; }
        .reveal.active { opacity: 1; transform: translateY(0); }
    </style>

    <div class="main-wrapper">

        <section id="hero-section">
            <div class="hero-text reveal active">
                <p style="text-transform: uppercase; letter-spacing: 6px; font-weight: 600; color: #512da8; margin-bottom: 10px;">For You, Meira</p>
                <h1>Special Birthday</h1>
                <p>Silakan klik tombol di bawah untuk memulai.</p>
                <button onclick="startSurprise(this)" class="btn-main">Mulai Kejutan ✨</button>
            </div>
        </section>

        <form id="mainQuizForm">
            @csrf
            @php
                $quizzes = [
                    ['id' => 'color', 'title' => 'Favorite Color', 'subtitle' => 'Warna apa yang paling kamu sukai?', 'options' => ['Merah','Pink','Hijau','Kuning','Biru']],
                    ['id' => 'musician', 'title' => 'Favorite Artist', 'subtitle' => 'Siapa yang lagunya paling sering kamu putar?', 'options' => ['Hindia','Taylor Swift','Nadin Amizah','Tulus','Rossa']],
                    ['id' => 'snack', 'title' => 'Favorite Snack', 'subtitle' => 'Cemilan yang nggak pernah salah buat kamu', 'options' => ['Keju','Coklat','Popcorn','Kacang','Keripik']],
                    ['id' => 'outfit', 'title' => 'Daily Outfit', 'subtitle' => 'OOTD yang bikin kamu paling nyaman', 'options' => ['Casual','Vintage','Chic','Sporty','Elegant']],
                    ['id' => 'place', 'title' => 'Dream Place', 'subtitle' => 'Tempat yang ingin kamu datangi hari ini', 'options' => ['Pantai','Cafe','Gym','Bioskop','Taman']]
                ];
            @endphp

            @foreach($quizzes as $index => $quiz)
            <section @if($index === 4) id="last-quiz-section" @endif>
                <div class="glass-card reveal">
                    <h1>{{ $quiz['title'] }}</h1>
                    <p class="subtitle">{{ $quiz['subtitle'] }}</p>
                    <div class="quiz-scroll">
                        @foreach($quiz['options'] as $opt)
                        <div onclick="setVal('{{ $quiz['id'] }}', '{{ $opt }}', this)" class="quiz-item">
                            <img src="{{ asset('img/'.strtolower(str_replace(' ', '', $opt)).'.jpg') }}" alt="{{ $opt }}">
                            <span>{{ $opt }}</span>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="{{ $quiz['id'] }}" id="db_{{ $quiz['id'] }}">
                </div>
            </section>
            @endforeach
        </form>

        <section id="slideshow-area">
            <div class="glass-card reveal">
                <h1>Our Memories</h1>
                <p class="subtitle">Setiap detik bersamamu adalah cerita indah.</p>
                <div class="swiper-container-wrapper">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @for ($i = 1; $i <= 10; $i++)
                            <div class="swiper-slide">
                                <img src="{{ asset('img/memory' . $i . '.jpg') }}" alt="Kenangan {{ $i }}">
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div style="margin-top: 50px;">
                    <button onclick="scrollToNext(this)" class="btn-main">Lanjut ❤️</button>
                </div>
            </div>
        </section>

        <section id="final-section">
            <div id="cake-area" class="glass-card reveal">
                <h1>Make a Wish</h1>
                <p class="subtitle">Tarik napas, ucapkan harapan, dan tiup lilinnya!</p>
                <div style="position: relative; display: inline-block; margin: 40px 0;">
                    <img src="{{ asset('img/cake.png') }}" style="width: 240px;">
                    <div id="api-lilin" class="flame"></div>
                </div>
                <br>
                <button onclick="tiupLilin()" class="btn-main">Tiup Lilin 🌬️</button>
            </div>

            <div id="final-card" class="glass-card reveal" style="display: none; padding: 60px 20px;">
                <div style="font-size: 80px; margin-bottom: 20px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));">🎂</div>
                <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                    <h1 style="color: #512da8; font-size: 2.5rem; margin-bottom: 20px;">Happy Birthday, Meira!</h1>
                    <p style="font-size: 18px; color: #555; line-height: 1.8; margin-bottom: 40px; padding: 0 30px;">
                        Semoga harimu luar biasa, seperti kamu yang selalu luar biasa bagi orang-orang di sekitarmu.
                        Terima kasih sudah menjadi bagian terindah dalam hidup ini.
                    </p>
                </div>
                <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; gap: 15px; border-top: 1px dashed #eee; margin-top: 30px; padding-top: 30px;">
                    <p style="font-size: 13px; color: #aaa;">Klik untuk mengakhiri kejutan</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-main" style="min-width: 250px;">Selesai & Logout</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        const audio = document.getElementById('bgMusic');

        function startSurprise(btn) {
            audio.play().catch(e => console.log("Audio play blocked"));
            scrollToNext(btn);
        }

        function setVal(category, value, element) {
            const container = element.parentElement;
            container.querySelectorAll('.quiz-item').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
            document.getElementById('db_' + category).value = value;
            setTimeout(() => {
                const currentSection = element.closest('section');
                let nextSection = (currentSection.id === 'last-quiz-section') ? document.getElementById('slideshow-area') : currentSection.nextElementSibling;
                if (nextSection) nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 600);
        }

        function scrollToNext(btn) {
            const currentSection = btn.closest('section');
            const nextSection = currentSection.nextElementSibling;
            if (nextSection) nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        async function tiupLilin() {
            const formData = new FormData(document.getElementById('mainQuizForm'));
            fetch("{{ route('birthday.store') }}", { method: 'POST', body: formData, headers: {'X-Requested-With': 'XMLHttpRequest'}});
            document.getElementById('api-lilin').style.display = 'none';
            confetti({ particleCount: 250, spread: 100, origin: { y: 0.6 }, colors: ['#512da8', '#ffffff', '#ffd700'] });
            setTimeout(() => {
                document.getElementById('cake-area').style.display = 'none';
                const final = document.getElementById('final-card');
                final.style.display = 'block';
                setTimeout(() => final.classList.add('active'), 50);
            }, 1200);
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('active'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        new Swiper(".mySwiper", {
            loop: true,
            speed: 8000,
            autoplay: { delay: 0, disableOnInteraction: false },
            slidesPerView: "auto",
            spaceBetween: 25,
            allowTouchMove: false,
            freeMode: true,
        });
    </script>
</x-app-layout>