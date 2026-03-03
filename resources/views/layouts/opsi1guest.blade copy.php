<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:600,700,800|outfit:300,400,500,600,700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:       #374773;
            --navy-mid:   #2c3a5e;
            --navy-deep:  #1b2540;
            --navy-ink:   #111827;
            --gold:       #FDB813;
            --gold-light: #fdd05a;
            --gold-dim:   rgba(253,184,19,.18);
            --white:      #ffffff;
            --off-white:  #f7f8fc;
            --border:     #e8ecf4;
            --muted:      #8893a8;
            --text:       #1e2a45;
        }

        html, body {
            height: 100%;
            font-family: 'Outfit', sans-serif;
            background: var(--off-white);
            overflow: hidden;
        }

        /* ══════════════════════════════════
           PAGE SHELL — full viewport split
        ══════════════════════════════════ */
        .shell {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* ══════════════════════════════════
           LEFT SIDEBAR
        ══════════════════════════════════ */
        .sidebar {
            width: 420px;
            min-width: 420px;
            background: var(--navy-deep);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        /* Layered background mesh */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 120% 60% at 10% 20%,  rgba(253,184,19,.12) 0%, transparent 55%),
                radial-gradient(ellipse 80%  80% at 90% 80%,  rgba(55,71,115,.6)   0%, transparent 60%),
                radial-gradient(ellipse 60%  50% at 50% 110%, rgba(253,184,19,.07) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Geometric grid pattern overlay */
        .sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        /* Floating decorative rings */
        .ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(253,184,19,.15);
            pointer-events: none;
            animation: pulse-ring 6s ease-in-out infinite;
        }
        .ring-1 { width: 300px; height: 300px; top: -80px;  left: -100px; animation-delay: 0s; }
        .ring-2 { width: 180px; height: 180px; top:  60px;  left:  40px;  animation-delay: 1s; border-color: rgba(253,184,19,.08); }
        .ring-3 { width: 400px; height: 400px; bottom: -160px; right: -140px; animation-delay: 2s; }
        .ring-4 { width: 120px; height: 120px; bottom: 120px; left: 30px;  animation-delay: 3s; border-color: rgba(255,255,255,.06); }

        @keyframes pulse-ring {
            0%, 100% { transform: scale(1);    opacity: 1; }
            50%       { transform: scale(1.06); opacity: .6; }
        }

        /* Sidebar content wrapper */
        .sidebar-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 48px 44px;
        }

        /* Logo area */
        .sb-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            animation: slideRight .7s cubic-bezier(.16,1,.3,1) both;
        }
        .sb-logo-mark {
            width: 50px; height: 50px;
            background: var(--gold);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(253,184,19,.3);
            flex-shrink: 0;
        }
        .sb-logo-mark img {
            width: 30px; height: 30px;
            object-fit: contain;
        }
        .sb-logo-text {
            color: var(--white);
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.3;
        }
        .sb-logo-text span {
            display: block;
            font-size: .65rem;
            font-weight: 400;
            color: rgba(255,255,255,.45);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Gold divider */
        .sb-divider {
            width: 40px; height: 2px;
            background: var(--gold);
            border-radius: 2px;
            margin: 36px 0;
            animation: slideRight .7s .1s cubic-bezier(.16,1,.3,1) both;
        }

        /* Main headline */
        .sb-headline {
            animation: slideRight .7s .18s cubic-bezier(.16,1,.3,1) both;
        }
        .sb-headline .eyebrow {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 14px;
        }
        .sb-headline h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1.25;
            letter-spacing: -.01em;
        }
        .sb-headline h1 em {
            font-style: italic;
            color: var(--gold-light);
        }
        .sb-headline p {
            margin-top: 16px;
            font-size: .82rem;
            font-weight: 300;
            color: rgba(255,255,255,.55);
            line-height: 1.75;
        }

        /* ZI Banner */
        .zi-banner {
            margin-top: 36px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(253,184,19,.2);
            border-radius: 12px;
            padding: 18px 20px;
            animation: slideRight .7s .28s cubic-bezier(.16,1,.3,1) both;
            position: relative;
            overflow: hidden;
        }
        .zi-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 3px; height: 100%;
            background: var(--gold);
            border-radius: 3px 0 0 3px;
        }
        .zi-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--gold-dim);
            border: 1px solid rgba(253,184,19,.3);
            border-radius: 20px;
            padding: 4px 10px;
            margin-bottom: 10px;
        }
        .zi-badge svg {
            width: 12px; height: 12px;
            fill: none; stroke: var(--gold);
            stroke-width: 2.2;
            stroke-linecap: round; stroke-linejoin: round;
        }
        .zi-badge span {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--gold);
        }
        .zi-banner p {
            font-size: .76rem;
            font-weight: 400;
            color: rgba(255,255,255,.7);
            line-height: 1.7;
        }
        .zi-banner strong { color: var(--gold); font-weight: 600; }
        .zi-banner b { color: rgba(255,255,255,.95); font-weight: 500; }

        /* Stats row */
        .sb-stats {
            display: flex;
            gap: 0;
            margin-top: 40px;
            animation: slideRight .7s .38s cubic-bezier(.16,1,.3,1) both;
        }
        .stat-item {
            flex: 1;
            padding: 16px 0;
            border-right: 1px solid rgba(255,255,255,.08);
            text-align: center;
        }
        .stat-item:first-child { text-align: left; }
        .stat-item:last-child  { border-right: none; text-align: right; }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--gold);
            line-height: 1;
        }
        .stat-label {
            font-size: .62rem;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
            margin-top: 5px;
        }

        /* Footer of sidebar */
        .sb-footer {
            margin-top: auto;
            padding-top: 32px;
            animation: slideRight .7s .45s cubic-bezier(.16,1,.3,1) both;
        }
        .sb-footer p {
            font-size: .65rem;
            color: rgba(255,255,255,.25);
            letter-spacing: .05em;
        }
        .sb-footer strong { color: rgba(255,255,255,.4); }

        /* ══════════════════════════════════
           RIGHT — FORM AREA
        ══════════════════════════════════ */
        .form-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 64px;
            background: var(--off-white);
            position: relative;
            overflow-y: auto;
        }

        /* Subtle dot grid bg */
        .form-area::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(55,71,115,.08) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .form-wrap {
            position: relative;
            width: 100%;
            max-width: 400px;
            animation: slideUp .7s .15s cubic-bezier(.16,1,.3,1) both;
        }

        /* Top label */
        .form-eyebrow {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-eyebrow::before {
            content: '';
            display: inline-block;
            width: 20px; height: 2px;
            background: var(--gold);
            border-radius: 2px;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -.02em;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .form-subtitle {
            font-size: .82rem;
            color: var(--muted);
            margin-bottom: 36px;
            font-weight: 400;
        }

        /* Card container */
        .form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 36px 32px;
            box-shadow:
                0 1px 2px rgba(55,71,115,.04),
                0 6px 20px rgba(55,71,115,.08),
                0 24px 48px rgba(55,71,115,.06);
            position: relative;
            overflow: hidden;
        }

        /* Top accent */
        .form-card::before {
            content: '';
            position: absolute;
            top: 0; left: 32px; right: 32px;
            height: 3px;
            background: linear-gradient(90deg, var(--navy), var(--gold) 60%, transparent);
            border-radius: 0 0 3px 3px;
        }

        /* ── Form field styles ── */
        .field { margin-bottom: 20px; }

        .field label,
        .card-inner label {
            display: block;
            font-size: .67rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            background: var(--off-white);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .input-wrap:focus-within {
            border-color: var(--navy);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(55,71,115,.08);
        }
        .input-icon {
            display: flex;
            align-items: center;
            padding: 0 14px;
            color: var(--muted);
            flex-shrink: 0;
        }
        .input-icon svg {
            width: 16px; height: 16px;
            fill: none; stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round; stroke-linejoin: round;
        }
        .input-wrap input {
            flex: 1;
            padding: 13px 14px 13px 0;
            background: transparent;
            border: none;
            outline: none;
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            color: var(--text);
        }
        .input-wrap input::placeholder { color: #b8bfce; }

        .toggle-pw {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0 14px;
            color: var(--muted);
            display: flex;
            align-items: center;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--navy); }
        .toggle-pw svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--navy);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: .88rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
            transition: background .25s, transform .15s, box-shadow .25s;
            box-shadow: 0 4px 16px rgba(55,71,115,.28);
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.1) 0%, transparent 60%);
            pointer-events: none;
        }
        .btn-submit:hover {
            background: var(--navy-mid);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(55,71,115,.36);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Error */
        .error-box {
            background: rgba(192,57,43,.06);
            border: 1px solid rgba(192,57,43,.2);
            border-left: 3px solid #c0392b;
            border-radius: 0 10px 10px 0;
            padding: 10px 14px;
            margin-bottom: 20px;
            font-size: .76rem;
            color: #b5372a;
            line-height: 1.6;
        }

        /* Copyright below card */
        .form-copyright {
            margin-top: 24px;
            text-align: center;
            font-size: .68rem;
            color: var(--muted);
            letter-spacing: .04em;
            animation: slideUp .7s .35s cubic-bezier(.16,1,.3,1) both;
        }
        .form-copyright strong { color: var(--navy); }

        /* ══════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════ */
        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-24px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ══════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════ */
        @media (max-width: 900px) {
            .sidebar { display: none; }
            .form-area { padding: 40px 24px; }
        }
    </style>
</head>
<body>

<div class="shell">

    <!-- ═══════════════ SIDEBAR ═══════════════ -->
    <aside class="sidebar">
        <!-- Decorative rings -->
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>
        <div class="ring ring-4"></div>

        <div class="sidebar-content">

            <!-- Logo -->
            <div class="sb-logo">
                <div class="sb-logo-mark">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo">
                </div>
                <div class="sb-logo-text">
                    {{ config('app.name', 'Laravel') }}
                    <span>Kementerian Pekerjaan Umum</span>
                </div>
            </div>

            <div class="sb-divider"></div>

            <!-- Headline -->
            <div class="sb-headline">
                <p class="eyebrow">Portal Layanan Digital</p>
                <h1>Pusat Data &amp;<br><em>Teknologi Informasi</em></h1>
                <p>
                    Platform terpadu pengelolaan data dan teknologi
                    informasi untuk mendukung transformasi digital
                    Kementerian Pekerjaan Umum.
                </p>
            </div>

            <!-- ZI / WBBM Banner -->
            <div class="zi-banner">
                <div class="zi-badge">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <polyline points="9 12 11 14 15 10"/>
                    </svg>
                    <span>Zona Integritas · WBBM</span>
                </div>
                <p>
                    Dalam menunjang <strong>Zona Integritas</strong> menuju
                    <strong>Wilayah Birokrasi Bersih dan Melayani (WBBM)</strong>,
                    PUSDATIN berkomitmen meningkatkan kualitas layanan publik
                    yang <b>bebas dari korupsi</b> dan memberikan <b>pelayanan prima</b>.
                </p>
            </div>

            <!-- Stats -->
            <div class="sb-stats">
                <div class="stat-item">
                    <div class="stat-num">2024</div>
                    <div class="stat-label">Tahun Aktif</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">WBBM</div>
                    <div class="stat-label">Target ZI</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">PU</div>
                    <div class="stat-label">Kementerian</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="sb-footer">
                <p>&copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong>. All rights reserved.</p>
            </div>

        </div>
    </aside>

    <!-- ═══════════════ FORM AREA ═══════════════ -->
    <main class="form-area">
        <div class="form-wrap">

            <p class="form-eyebrow">Autentikasi Pengguna</p>
            <h2 class="form-title">Selamat Datang</h2>
            <p class="form-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>

            <div class="form-card">
                {{ $slot }}
            </div>

            <p class="form-copyright">
                &copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong> &mdash;
                Kementerian Pekerjaan Umum
            </p>
        </div>
    </main>

</div>

</body>
</html>