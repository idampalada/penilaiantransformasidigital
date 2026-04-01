<x-guest-layout>

    <!-- Gold accent label -->
    <p class="text-[#f59e0b] tracking-widest text-sm font-semibold uppercase mb-5 gold-line">
        Autentikasi Pengguna
    </p>

    <h2 class="title-font text-5xl font-bold text-[#1e3a5f]">
        Selamat Datang
    </h2>

    <p class="text-[#8a93a6] mt-3 mb-10 text-base">
        Masukkan kredensial Anda untuk melanjutkan
    </p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- USER ID -->
        <div>
            <label class="block text-sm font-semibold tracking-widest text-[#1e3a5f] uppercase mb-2">
                User ID
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#8a93a6]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                </span>
                <input type="text"
                    name="email"
                    value="{{ old('email') }}"
                    required autofocus
                    placeholder="userpusdatin@pu.go.id"
                    class="custom-input w-full rounded-xl px-5 py-4 pl-12 text-base text-[#1e3a5f] placeholder-[#9ca3af]">
            </div>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div>
            <label class="block text-sm font-semibold tracking-widest text-[#1e3a5f] uppercase mb-2">
                Password
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#8a93a6]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                    </svg>
                </span>
                <input type="password"
                    id="password-input"
                    name="password"
                    required
                    placeholder="••••••••••"
                    class="custom-input w-full rounded-xl px-5 py-4 pl-12 pr-12 text-base text-[#1e3a5f] placeholder-[#9ca3af]">
                <!-- Eye toggle -->
                <button type="button"
                    onclick="togglePassword()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#8a93a6] hover:text-[#1e3a5f] transition-colors">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- BUTTON -->
        <button type="submit" class="masuk-btn w-full text-white font-semibold py-4 rounded-xl tracking-widest text-base transition-all duration-300 mt-2">
            MASUK
        </button>

        <!-- LINK DASHBOARD -->
<div class="text-center mt-4">
    <a href="/dashboard" class="text-sm text-[#1e3a5f] hover:text-[#f59e0b] transition-colors duration-200 font-medium">
        Lihat Dashboard Penilaian
    </a>
</div>

    </form>

    <!-- CALL CENTER -->
    <div class="mt-10 text-center">

        <!-- Divider with label -->
        <div class="flex items-center gap-3 mb-5">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs tracking-[0.2em] text-[#b0b8c8] font-semibold uppercase">Bantuan</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- Card -->
        <div class="rounded-2xl border border-[#eaecf0] bg-[#f9fafb] p-5">

            <!-- Header -->
            <p class="text-sm font-bold text-[#1e3a5f] tracking-[0.15em] uppercase mb-1">Call Center</p>
            <p class="text-sm text-[#8a93a6] mb-4">Penilaian Transformasi Digital</p>

            <!-- Phone buttons -->
            <div class="space-y-2.5">
                <a href="tel:08131689958"
                    class="flex items-center justify-center gap-3 w-full bg-white border border-[#eaecf0] rounded-xl px-4 py-3 hover:border-[#f59e0b] hover:shadow-sm transition-all duration-200 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#f59e0b] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                    </svg>
                    <span class="text-base font-semibold text-[#1e3a5f]">0817-846-621</span>
                </a>
            </div>
        </div>

        <p class="text-sm text-[#c0c7d3] mt-6">
            © 2026 <strong class="text-[#8a93a6]">Transformasi Digital</strong> — Kementerian Pekerjaan Umum
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password-input');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Highlight gold-line pseudo element for the right panel label
        // (uses same CSS class defined in layout)
    </script>

</x-guest-layout>