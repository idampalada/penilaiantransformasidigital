<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login — PUSDATIN</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .title-font { font-family: 'Playfair Display', serif; }

        /* Animated dots */
        @keyframes float1 {
            0%, 100% { transform: translateY(0px); opacity: 0.6; }
            50% { transform: translateY(-12px); opacity: 1; }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0px); opacity: 0.4; }
            50% { transform: translateY(-8px); opacity: 0.8; }
        }
        .dot-float-1 { animation: float1 4s ease-in-out infinite; }
        .dot-float-2 { animation: float2 5s ease-in-out infinite 1s; }
        .dot-float-3 { animation: float1 6s ease-in-out infinite 2s; }

        /* Background image on left panel */
        .left-panel {
            background-image: url('/pusdatin.jpeg');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        /* Dark overlay so text stays readable */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(240, 241, 243, 0.82);
            pointer-events: none;
            z-index: 0;
        }
        /* Ensure all content inside sits above the overlay */
        .left-panel > * {
            position: relative;
            z-index: 1;
        }

        /* Golden accent line */
        .gold-line::before {
            content: '';
            display: inline-block;
            width: 2rem;
            height: 2px;
            background-color: #f59e0b;
            margin-right: 0.75rem;
            vertical-align: middle;
        }

        /* Right panel decorations */
        .right-panel {
            position: relative;
            overflow: hidden;
        }
        /* Top-left corner bracket — emas tipis */
        .right-panel::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            width: 32px;
            height: 32px;
            border-top: 1.5px solid #f59e0b;
            border-left: 1.5px solid #f59e0b;
            pointer-events: none;
            z-index: 2;
            opacity: 0.85;
        }
        /* Bottom-right corner bracket — navy tipis */
        .right-panel::after {
            content: '';
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 32px;
            height: 32px;
            border-bottom: 1.5px solid #1e3a5f;
            border-right: 1.5px solid #1e3a5f;
            pointer-events: none;
            z-index: 2;
            opacity: 0.5;
        }
        /* Ensure form content stays above decorations */
        .right-panel > div {
            position: relative;
            z-index: 1;
        }

        /* ── Button MASUK shimmer ── */
        @keyframes shimmer {
            0%   { transform: translateX(-120%) skewX(-20deg); }
            100% { transform: translateX(220%) skewX(-20deg); }
        }
        .masuk-btn {
            background: #1e3a5f;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(30, 58, 95, 0.35);
            transition: box-shadow 0.3s ease, background 0.3s ease;
        }
        .masuk-btn::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 40%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
            transform: translateX(-120%) skewX(-20deg);
            animation: shimmer 2.6s ease-in-out infinite;
        }
        .masuk-btn:hover {
            background: #162d4a;
            box-shadow: 0 6px 28px rgba(30, 58, 95, 0.5);
        }

        /* ── Zona Integritas badge shimmer ── */
        @keyframes badgeShimmer {
            0%   { transform: translateX(-120%) skewX(-20deg); }
            100% { transform: translateX(280%) skewX(-20deg); }
        }
        .zona-badge {
            position: relative;
            overflow: hidden;
        }
        .zona-badge::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 35%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
            transform: translateX(-120%) skewX(-20deg);
            animation: badgeShimmer 3s ease-in-out infinite 0.5s;
        }

        /* Input focus style */
        .custom-input {
            background-color: #eef2fb;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        .custom-input:focus {
            background-color: #fff;
            border-color: #1e3a5f;
            outline: none;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.08);
        }
        /* Right panel top gradient bar */
        .right-panel-topbar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #1e3a5f 0%, #f59e0b 100%);
            z-index: 10;
        }
    </style>
</head>

<body class="min-h-screen flex bg-[#f0f1f3]">

    <!-- LEFT SIDE -->
    <div class="hidden lg:flex w-3/5 left-panel p-16 xl:p-24 flex-col justify-between relative overflow-hidden">

        <!-- Top: Logo -->
        <div class="flex items-center gap-4">
            <img src="/favicon.ico" class="w-12 h-12 object-contain">
            <div>
                <p class="text-xs font-semibold text-[#1e3a5f] tracking-wider leading-tight">KEMENTERIAN</p>
                <p class="text-xs font-semibold text-[#1e3a5f] tracking-wider leading-tight">PEKERJAAN UMUM</p>
            </div>
        </div>

        <!-- Middle: Main Content -->
        <div class="flex-1 flex flex-col justify-center mt-16">

            <p class="gold-line text-[#f59e0b] tracking-widest text-xs font-semibold uppercase mb-6">
                Pusat Data Teknologi dan Informasi
            </p>

            <h1 class="title-font text-7xl xl:text-8xl font-bold text-[#1e3a5f] leading-[0.9] mb-2">
                Transformasi
            </h1>
            <h1 class="title-font text-7xl xl:text-8xl font-bold text-[#f59e0b] leading-[0.9] mb-2">
                Digital
            </h1>
            <!-- Underline accent -->
            <div class="w-24 h-1 bg-[#f59e0b] mt-1 mb-8 rounded-full"></div>

            <p class="text-[#5a6478] text-base leading-relaxed max-w-sm">
                Platform terpadu pengelolaan data dan teknologi informasi
                untuk mendukung transformasi digital Kementerian
                Pekerjaan Umum.
            </p>

            <!-- Zona Integritas Badge -->
            <div class="zona-badge mt-10 bg-[#1e3a5f] text-white px-6 py-3 rounded-full w-full max-w-sm flex items-center gap-3 text-sm font-medium">
                <span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b] inline-block"></span>
                Zona Integritas · WBBM
            </div>

            <!-- Zona description box -->
            <div class="mt-6 border-l-4 border-[#f59e0b] pl-5 max-w-sm">
                <p class="text-[#5a6478] text-sm leading-relaxed">
                    Dalam menunjang Zona Integritas menuju Wilayah Birokrasi
                    Bersih dan Melayani (WBBM), PUSDATIN berkomitmen
                    meningkatkan kualitas layanan publik yang bebas dari
                    korupsi dan memberikan pelayanan prima.
                </p>
            </div>
        </div>

        <!-- Bottom: Stats -->
        <div class="flex gap-14 mt-10">
            <div>
                <h3 class="title-font text-3xl font-bold text-[#1e3a5f]">2026</h3>
                <p class="text-xs text-[#8a93a6] tracking-widest mt-1 uppercase">Tahun Aktif</p>
            </div>
            <div class="border-l border-[#d1d5db] pl-14">
                <h3 class="title-font text-3xl font-bold text-[#1e3a5f]">WBBM</h3>
                <p class="text-xs text-[#8a93a6] tracking-widest mt-1 uppercase">Target ZI</p>
            </div>
            <div class="border-l border-[#d1d5db] pl-14">
                <h3 class="title-font text-3xl font-bold text-[#1e3a5f]">PU</h3>
                <p class="text-xs text-[#8a93a6] tracking-widest mt-1 uppercase">Kementerian</p>
            </div>
        </div>

        <!-- Decorative floating dots -->
        <div class="absolute bottom-48 right-24 w-4 h-4 rounded-full bg-[#f59e0b] dot-float-1"></div>
        <div class="absolute bottom-36 right-16 w-2.5 h-2.5 rounded-full bg-[#1e3a5f] dot-float-2"></div>
        <div class="absolute bottom-28 right-32 w-3 h-3 rounded-full bg-[#f59e0b] opacity-50 dot-float-3"></div>
        <div class="absolute top-1/2 right-10 w-2 h-2 rounded-full bg-[#1e3a5f] opacity-30 dot-float-2"></div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="w-full lg:w-2/5 flex items-center justify-center px-12 right-panel" style="background: linear-gradient(160deg, #ffffff 60%, #f4f6fb 100%);">

        <!-- Top gradient bar -->
        <div class="right-panel-topbar"></div>

        <!-- Decorative circles top-right -->
        <div style="position:absolute;top:-70px;right:-70px;width:220px;height:220px;border-radius:50%;border:2px solid rgba(245,158,11,0.22);pointer-events:none;z-index:0;"></div>
        <div style="position:absolute;top:-25px;right:-25px;width:110px;height:110px;border-radius:50%;border:1.5px solid rgba(245,158,11,0.14);pointer-events:none;z-index:0;"></div>
        <!-- Decorative circle bottom-left -->
        <div style="position:absolute;bottom:-90px;left:-90px;width:280px;height:280px;border-radius:50%;border:2px solid rgba(30,58,95,0.09);pointer-events:none;z-index:0;"></div>

        <div class="w-full max-w-md" style="position:relative;z-index:1;">
            {{ $slot }}
        </div>

    </div>

</body>
</html>