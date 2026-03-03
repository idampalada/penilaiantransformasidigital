<x-guest-layout>

    <!-- Header -->
    <div class="bg-gray-100 text-center py-6 rounded-t-lg">
        <img src="{{ asset('favicon.ico') }}" 
             style="width:50px; height:50px;"
             class="mx-auto mb-2 object-contain">

        <h1 class="text-lg italic font-semibold">Penilaian Transformasi Digital</h1>
        <h2 class="text-xl font-bold">Pusat Data dan Teknologi Informasi</h2>
    </div>

    <div class="p-6">

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- User ID --}}
            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-blue-400">
                <span class="flex items-center justify-center px-3 text-gray-400 bg-white h-full">
                    {{-- Person icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </span>
                <input type="text"
                    name="email"
                    value="{{ old('email') }}"
                    required autofocus
                    placeholder="User ID"
                    class="flex-1 py-2 pr-4 bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
            </div>

            {{-- Password --}}
            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-blue-400">
                <span class="flex items-center justify-center px-3 text-gray-400 bg-white">
                    {{-- QR Code icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h7v7H3zm1 1v5h5V4zm1 1h3v3H5zM3 14h7v7H3zm1 1v5h5v-5zm1 1h3v3H5zM14 3h7v7h-7zm1 1v5h5V4zm1 1h3v3h-3zM14 14h2v2h-2zm2 2h2v2h-2zm2-2h2v2h-2zm-2 4h2v2h-2zm2 0h2v2h-2zm2-2h-2v-2h2z"/>
                    </svg>
                </span>
                <input type="password"
                    name="password"
                    required
                    placeholder="Password"
                    class="flex-1 py-2 pr-4 bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
            </div>

            <button type="submit"
                style="background:#3f79ad; color:white;"
                class="w-full py-2 font-bold tracking-widest rounded-md text-sm">
                MASUK
            </button>
        </form>

        <div class="mt-6 border border-gray-300 rounded-md p-4 text-center shadow-sm" style="background-color: #f8fafc;">
            <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                Dalam menunjang Zona Integritas menuju Wilayah Birokrasi Bersih dan Melayani (WBBM), PUSDATIN berkomitmen meningkatkan kualitas layanan publik yang bebas dari korupsi dan memberikan pelayanan prima.
            </p>
            <div class="flex justify-between items-center text-center px-2">
                <div class="stat flex-1">
                    <div class="stat-num font-bold text-gray-800 text-lg">2024</div>
                    <div class="stat-label text-xs text-gray-500">Tahun Aktif</div>
                </div>
                <div class="stat flex-1 border-x border-gray-200">
                    <div class="stat-num font-bold text-gray-800 text-lg">WBBM</div>
                    <div class="stat-label text-xs text-gray-500">Target ZI</div>
                </div>
                <div class="stat flex-1">
                    <div class="stat-num font-bold text-gray-800 text-lg">PU</div>
                    <div class="stat-label text-xs text-gray-500">Kementerian</div>
                </div>
            </div>
        </div>

        <div class="text-center mt-6 text-sm text-gray-700">
            <p class="font-bold">Call Center</p>
            <p class="font-semibold">Penilaian Transformasi Digital</p>
            <div class="mt-3 space-y-1">
                <p>📱 0813-1689-9598</p>
                <p>📱 0819-3871-3429</p>
            </div>
        </div>

    </div>

</x-guest-layout>