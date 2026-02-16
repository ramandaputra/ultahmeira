<x-guest-layout>
    <audio id="preloaderAudio" src="{{ asset('audio/ultahmeira.mp3') }}" preload="auto"></audio>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-pink-600">Halo Cantik! ❤️</h2>
        <p class="text-sm text-gray-500">Login dulu yuk buat liat kejutannya.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-pink-500 hover:bg-pink-600">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const audio = document.getElementById('preloaderAudio');
            
            // RESET AUDIO DATA SAAT LOGIN (Penting agar tidak lanjut dari sisa lagu kemarin)
            localStorage.setItem('audioTime', '0');
            localStorage.setItem('playMusic', 'true');

            // Pancingan interaksi agar browser memberi izin suara
            audio.play().then(() => {
                setTimeout(() => {
                    this.submit();
                }, 100);
            }).catch(error => {
                // Jika autoplay diblokir, kita tetap paksa set playMusic true
                this.submit();
            });
        });
    </script>
</x-guest-layout>