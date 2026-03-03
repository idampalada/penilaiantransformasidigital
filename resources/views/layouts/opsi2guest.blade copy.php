<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — PUSDATIN Kementerian Pekerjaan Umum</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<style>
  :root {
    --navy: #374773;
    --gold: #FDB813;
    --gold-light: #ffd04d;
    --bg: #eef0f5;
    --card: #ffffff;
    --text: #374773;
    --muted: #6b7280;
    --border: #e2e6ef;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    display: flex;
    overflow: hidden;
    position: relative;
  }

  /* ===== ANIMATED BACKGROUND ===== */
  .bg-canvas {
    position: fixed;
    inset: 0;
    z-index: 0;
    overflow: hidden;
  }

  .bg-canvas::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, #c0c8d8 1px, transparent 1px);
    background-size: 28px 28px;
    opacity: 0.45;
    animation: gridShift 20s linear infinite;
  }
  @keyframes gridShift {
    0%   { background-position: 0 0; }
    100% { background-position: 28px 28px; }
  }

  /* Blobs */
  .blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.18;
    animation: blobFloat linear infinite;
  }
  .blob-1 { width: 500px; height: 500px; background: var(--gold); top: -100px; left: -100px; animation-duration: 18s; }
  .blob-2 { width: 400px; height: 400px; background: var(--navy); bottom: -80px; right: 20%; animation-duration: 24s; animation-direction: reverse; }
  .blob-3 { width: 300px; height: 300px; background: #5a6fa8; top: 40%; right: -80px; animation-duration: 20s; }

  @keyframes blobFloat {
    0%   { transform: translate(0, 0) scale(1); }
    33%  { transform: translate(30px, -20px) scale(1.05); }
    66%  { transform: translate(-20px, 30px) scale(0.95); }
    100% { transform: translate(0, 0) scale(1); }
  }

  /* Geometric floating shapes */
  .geo-shape {
    position: absolute;
    opacity: 0;
    animation: geoFloat ease-in-out infinite;
    pointer-events: none;
  }
  @keyframes geoFloat {
    0%   { opacity: 0; transform: translateY(0) rotate(0deg); }
    10%  { opacity: 0.12; }
    90%  { opacity: 0.08; }
    100% { opacity: 0; transform: translateY(-120px) rotate(180deg); }
  }

  /* Floating particles */
  .particles { position: fixed; inset: 0; pointer-events: none; z-index: 1; }
  .particle {
    position: absolute;
    border-radius: 50%;
    background: var(--gold);
    opacity: 0;
    animation: particleFly linear infinite;
  }
  @keyframes particleFly {
    0%   { transform: translateY(100vh) scale(0); opacity: 0; }
    10%  { opacity: 0.6; }
    90%  { opacity: 0.3; }
    100% { transform: translateY(-10vh) scale(1); opacity: 0; }
  }

  /* Scanline overlay */
  .scanline {
    position: fixed; inset: 0; z-index: 1; pointer-events: none;
    background: repeating-linear-gradient(
      0deg,
      transparent,
      transparent 2px,
      rgba(55,71,115,0.015) 2px,
      rgba(55,71,115,0.015) 4px
    );
  }

  /* ===== LEFT PANEL ===== */
  .left-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px 80px;
    position: relative;
    z-index: 2;
    animation: slideInLeft 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
  }
  @keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-40px); }
    to   { opacity: 1; transform: translateX(0); }
  }

  .left-panel .logo-row {
    display: flex; align-items: center; gap: 14px; margin-bottom: 60px;
  }
  .logo-favicon {
    width: 48px; height: 48px;
    border-radius: 10px;
    object-fit: contain;
    display: block;
    animation: logoSpin 1s 0.5s cubic-bezier(0.16,1,0.3,1) both;
  }
  @keyframes logoSpin {
    from { opacity:0; transform: scale(0.5) rotate(-20deg); }
    to   { opacity:1; transform: scale(1) rotate(0deg); }
  }
  .logo-text { font-size: 13px; font-weight: 600; color: var(--navy); line-height: 1.3; }
  .logo-text small { font-weight: 300; color: var(--muted); display: block; }

  .panel-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase;
    color: var(--gold); font-weight: 600; margin-bottom: 16px;
    animation: fadeUp 0.7s 0.3s both;
  }
  .panel-eyebrow::before { content: ''; width: 24px; height: 2px; background: var(--gold); }

  .panel-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 4vw, 52px);
    color: var(--navy);
    line-height: 1.15;
    margin-bottom: 20px;
    animation: fadeUp 0.7s 0.45s both;
  }
  .panel-title span { color: var(--gold); position: relative; }
  .panel-title span::after {
    content: '';
    position: absolute;
    bottom: -4px; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--gold), transparent);
    transform-origin: left;
    animation: underlineGrow 1s 1.2s cubic-bezier(0.16,1,0.3,1) both;
  }
  @keyframes underlineGrow {
    from { transform: scaleX(0); }
    to   { transform: scaleX(1); }
  }

  .panel-desc {
    font-size: 15px; color: var(--muted); line-height: 1.7;
    max-width: 420px; margin-bottom: 48px;
    animation: fadeUp 0.7s 0.6s both;
    overflow: hidden;
  }

  /* Typewriter cursor */
  .cursor {
    display: inline-block;
    width: 2px; height: 1em;
    background: var(--gold);
    vertical-align: text-bottom;
    margin-left: 2px;
    animation: blink 0.8s step-end infinite;
  }
  @keyframes blink { 50% { opacity: 0; } }

  .zi-badge {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--navy); color: #fff;
    padding: 12px 20px; border-radius: 14px;
    font-size: 13px; font-weight: 500;
    margin-bottom: 16px;
    animation: fadeUp 0.7s 0.75s both;
    position: relative; overflow: hidden;
  }
  .zi-badge::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 60px; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    animation: shimmer 3s 2s infinite;
  }
  @keyframes shimmer {
    0%   { left: -100%; }
    100% { left: 200%; }
  }
  .zi-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold-light); animation: pulse 2s infinite; }
  @keyframes pulse { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.4); } }

  .zi-desc {
    font-size: 13px; color: var(--muted); line-height: 1.65;
    max-width: 400px; margin-bottom: 28px;
    padding: 14px 18px;
    background: rgba(55,71,115,0.05);
    border-left: 3px solid var(--gold);
    border-radius: 0 8px 8px 0;
    animation: fadeUp 0.7s 0.85s both;
  }

  .stats-row {
    display: flex; gap: 32px;
    animation: fadeUp 0.7s 0.9s both;
  }

  .stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 28px; color: var(--navy); font-weight: 700;
    transition: color 0.2s;
  }
  .stat:hover .stat-num { color: var(--gold); }

  .stat-label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 2px; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ===== RIGHT PANEL ===== */
  .right-panel {
    width: 480px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 48px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-left: 1px solid rgba(255,255,255,0.8);
    position: relative;
    z-index: 2;
    animation: slideInRight 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
  }
  @keyframes slideInRight {
    from { opacity: 0; transform: translateX(40px); }
    to   { opacity: 1; transform: translateX(0); }
  }

  /* Top progress bar */
  .progress-bar {
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--navy), var(--gold));
    transform-origin: left;
    animation: progressLoad 1.5s 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
  }
  @keyframes progressLoad {
    from { transform: scaleX(0); }
    to   { transform: scaleX(1); }
  }

  /* Animated corner accents */
  .corner-accent {
    position: absolute;
    width: 40px; height: 40px;
    pointer-events: none;
    animation: cornerPulse 4s ease-in-out infinite alternate;
  }
  .corner-accent.tl { top: 12px; left: 12px; border-top: 2px solid var(--gold); border-left: 2px solid var(--gold); }
  .corner-accent.br { bottom: 12px; right: 12px; border-bottom: 2px solid var(--gold); border-right: 2px solid var(--gold); }
  @keyframes cornerPulse {
    from { opacity: 0.3; width: 30px; height: 30px; }
    to   { opacity: 0.8; width: 45px; height: 45px; }
  }

  .card-eyebrow {
    font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase;
    color: var(--gold); font-weight: 600; margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
    animation: fadeUp 0.6s 0.6s both;
  }
  .card-eyebrow::before { content: ''; width: 18px; height: 2px; background: var(--gold); }

  .card-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px; color: var(--navy); margin-bottom: 6px;
    animation: fadeUp 0.6s 0.7s both;
  }

  .card-sub {
    font-size: 14px; color: var(--muted); margin-bottom: 36px;
    animation: fadeUp 0.6s 0.8s both;
  }

  /* Form */
  .form-group {
    width: 100%; margin-bottom: 20px;
    animation: fadeUp 0.6s both;
  }
  .form-group:nth-child(1) { animation-delay: 0.9s; }
  .form-group:nth-child(2) { animation-delay: 1.0s; }

  .form-label {
    font-size: 11px; font-weight: 600; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--navy);
    display: block; margin-bottom: 8px;
  }

  .input-wrap {
    position: relative;
    border-radius: 12px;
    background: #f4f6fb;
    border: 1.5px solid var(--border);
    transition: border-color 0.25s, box-shadow 0.25s, background 0.25s, transform 0.2s;
    overflow: hidden;
  }
  .input-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(253,184,19,0.08), transparent);
    opacity: 0;
    transition: opacity 0.25s;
    pointer-events: none;
  }
  .input-wrap:focus-within {
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(253,184,19,0.15);
    background: #fff;
    transform: translateY(-1px);
  }
  .input-wrap:focus-within::after { opacity: 1; }

  .input-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: var(--muted); width: 18px; height: 18px;
    transition: color 0.25s, transform 0.3s;
  }
  .input-wrap:focus-within .input-icon { color: var(--gold); transform: translateY(-50%) scale(1.1); }

  .input-wrap input {
    width: 100%; padding: 14px 44px;
    background: transparent; border: none; outline: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; color: var(--navy);
  }
  .input-wrap input::placeholder { color: #aab0be; }

  .eye-btn {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: var(--muted); padding: 4px; transition: color 0.2s, transform 0.2s;
  }
  .eye-btn:hover { color: var(--navy); transform: translateY(-50%) scale(1.15); }

  /* Scan line animation */
  .scan-line {
    position: absolute; bottom: 0; left: 0;
    height: 2px; width: 0;
    background: linear-gradient(90deg, var(--gold), var(--gold-light));
    border-radius: 0 0 12px 12px;
    transition: width 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
  }
  .input-wrap:focus-within .scan-line { width: 100%; }

  /* Floating label animation */
  .input-wrap input:not(:placeholder-shown) + .input-status,
  .input-wrap:focus-within .input-status {
    opacity: 1;
  }

  /* Submit button */
  .btn-masuk {
    width: 100%; padding: 16px;
    background: var(--navy);
    color: #fff; border: none; border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase;
    cursor: pointer; position: relative; overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s, background 0.3s;
    animation: fadeUp 0.6s 1.1s both;
  }
  .btn-masuk::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(253,184,19,0.2), transparent);
    opacity: 0; transition: opacity 0.25s;
  }
  .btn-masuk:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(30,42,74,0.3); }
  .btn-masuk:hover::before { opacity: 1; }
  .btn-masuk:active { transform: translateY(0) scale(0.98); }

  .btn-masuk::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 50%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    animation: btnShimmer 4s 2s infinite;
  }
  @keyframes btnShimmer {
    0%   { left: -100%; }
    100% { left: 250%; }
  }

  .btn-masuk .ripple {
    position: absolute; border-radius: 50%;
    background: rgba(255,255,255,0.25);
    transform: scale(0);
    animation: rippleAnim 0.6s linear;
    pointer-events: none;
  }
  @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

  /* Loading state */
  .btn-masuk.loading {
    pointer-events: none;
  }
  .btn-masuk .btn-text { transition: opacity 0.2s; }
  .btn-masuk .btn-spinner {
    position: absolute; left: 50%; top: 50%;
    transform: translate(-50%,-50%);
    width: 20px; height: 20px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    opacity: 0;
    animation: none;
    transition: opacity 0.2s;
  }
  .btn-masuk.loading .btn-text { opacity: 0; }
  .btn-masuk.loading .btn-spinner { opacity: 1; animation: spinnerSpin 0.7s linear infinite; }
  @keyframes spinnerSpin { to { transform: translate(-50%,-50%) rotate(360deg); } }

  .divider {
    display: flex; align-items: center; gap: 12px;
    margin: 28px 0 20px;
    animation: fadeUp 0.6s 1.2s both;
    width: 100%;
  }
  .divider::before, .divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }
  .divider span { font-size: 11px; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; }

  /* Call center */
  .callcenter-box {
    width: 100%; background: #f8f9fc; border-radius: 14px;
    padding: 20px; border: 1px solid var(--border);
    animation: fadeUp 0.6s 1.3s both;
  }
  .cc-title {
    font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--navy); font-weight: 700; text-align: center; margin-bottom: 4px;
  }
  .cc-sub { font-size: 12px; color: var(--muted); text-align: center; margin-bottom: 14px; }

  .cc-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 10px 16px; border-radius: 8px;
    border: 1.5px solid var(--border); background: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; color: var(--navy); font-weight: 500;
    cursor: pointer; margin-bottom: 8px;
    transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
    position: relative; overflow: hidden;
  }
  .cc-btn:last-child { margin-bottom: 0; }
  .cc-btn:hover {
    border-color: var(--gold);
    background: linear-gradient(135deg, #fff9ec, #fff);
    color: var(--navy);
    transform: translateX(6px);
    box-shadow: 0 4px 16px rgba(253,184,19,0.15);
  }
  .cc-btn svg { color: var(--gold); flex-shrink: 0; transition: transform 0.25s; }
  .cc-btn:hover svg { transform: scale(1.2) rotate(-5deg); }

  .footer-text {
    margin-top: 32px; font-size: 12px; color: var(--muted); text-align: center;
    animation: fadeUp 0.6s 1.4s both;
  }
  .footer-text strong { color: var(--navy); }

  /* Floating ring decorations */
  .ring {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(253,184,19,0.2);
    animation: ringPulse ease-in-out infinite alternate;
    pointer-events: none;
  }
  .ring-1 { width: 200px; height: 200px; top: -60px; right: -60px; animation-duration: 4s; }
  .ring-2 { width: 120px; height: 120px; bottom: 80px; left: -30px; animation-duration: 5s; animation-delay: 1s; }
  .ring-3 { width: 60px; height: 60px; bottom: 200px; right: 30px; animation-duration: 3s; animation-delay: 0.5s; }
  @keyframes ringPulse {
    from { transform: scale(1); opacity: 0.3; }
    to   { transform: scale(1.15); opacity: 0.8; }
  }

  /* ===== ORBIT ANIMATION (left panel decoration) ===== */
  .orbit-container {
    position: absolute;
    right: -60px; bottom: 80px;
    width: 200px; height: 200px;
    pointer-events: none;
    animation: fadeUp 0.7s 1.5s both;
  }
  .orbit-ring {
    position: absolute; inset: 0;
    border-radius: 50%;
    border: 1px dashed rgba(253,184,19,0.25);
    animation: orbitSpin linear infinite;
  }
  .orbit-ring:nth-child(1) { animation-duration: 12s; }
  .orbit-ring:nth-child(2) { inset: 20px; border-color: rgba(55,71,115,0.2); animation-duration: 18s; animation-direction: reverse; }
  .orbit-ring:nth-child(3) { inset: 40px; border-color: rgba(253,184,19,0.15); animation-duration: 8s; }
  @keyframes orbitSpin { to { transform: rotate(360deg); } }

  .orbit-dot {
    position: absolute;
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--gold);
    top: -3px; left: 50%; transform: translateX(-50%);
    box-shadow: 0 0 6px var(--gold);
  }
  .orbit-ring:nth-child(2) .orbit-dot { background: var(--navy); box-shadow: 0 0 6px var(--navy); }
  .orbit-ring:nth-child(3) .orbit-dot { background: var(--gold-light); width: 4px; height: 4px; top: -2px; }

  /* ===== WAVE animation at bottom of left panel ===== */
  .wave-container {
    position: absolute; bottom: 0; left: 0; right: 0; height: 60px;
    overflow: hidden; pointer-events: none;
  }
  .wave {
    position: absolute; bottom: 0;
    width: 200%; height: 100%;
    background: rgba(253,184,19,0.04);
    border-radius: 40% 60% 0 0;
    animation: waveSway ease-in-out infinite alternate;
  }
  .wave:nth-child(2) { animation-duration: 6s; animation-delay: 1s; background: rgba(55,71,115,0.03); }
  @keyframes waveSway {
    from { transform: translateX(-30%) scaleY(1); }
    to   { transform: translateX(0%) scaleY(1.3); }
  }

  /* ===== TOAST notification ===== */
  .toast {
    position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) translateY(80px);
    background: var(--navy); color: #fff;
    padding: 12px 24px; border-radius: 100px;
    font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 8px;
    box-shadow: 0 8px 32px rgba(55,71,115,0.3);
    z-index: 100;
    transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), opacity 0.4s;
    opacity: 0;
    pointer-events: none;
  }
  .toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }
  .toast-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold); }
</style>
</head>
<body>

<!-- Background -->
<div class="bg-canvas">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>
</div>
<div class="scanline"></div>

<!-- Floating particles -->
<div class="particles" id="particles"></div>

<!-- Left panel -->
<div class="left-panel">
  <div class="logo-row">
    <img src="/favicon.ico" class="logo-favicon" alt="PUSDATIN Logo" onerror="this.style.display='none'" />
    <div class="logo-text">
      PUSDATIN
      <small>Kementerian Pekerjaan Umum</small>
    </div>
  </div>

  <div class="panel-eyebrow">Portal Layanan Digital</div>
  <h1 class="panel-title">
    Pusat Data &amp;<br><span>Teknologi Informasi</span>
  </h1>
  <p class="panel-desc" id="typeDesc"></p>

  <div class="zi-badge">
    <div class="zi-dot"></div>
    Zona Integritas · WBBM
  </div>

  <p class="zi-desc">
    Dalam menunjang Zona Integritas menuju Wilayah Birokrasi Bersih dan Melayani (WBBM), PUSDATIN berkomitmen meningkatkan kualitas layanan publik yang bebas dari korupsi dan memberikan pelayanan prima.
  </p>

  <div class="stats-row">
    <div class="stat">
      <div class="stat-num" id="counter-year">0</div>
      <div class="stat-label">Tahun Aktif</div>
    </div>
    <div class="stat">
      <div class="stat-num">WBBM</div>
      <div class="stat-label">Target ZI</div>
    </div>
    <div class="stat">
      <div class="stat-num">PU</div>
      <div class="stat-label">Kementerian</div>
    </div>
  </div>

  <!-- Orbit decoration -->
  <div class="orbit-container">
    <div class="orbit-ring"><div class="orbit-dot"></div></div>
    <div class="orbit-ring"><div class="orbit-dot"></div></div>
    <div class="orbit-ring"><div class="orbit-dot"></div></div>
  </div>

  <!-- Wave -->
  <div class="wave-container">
    <div class="wave"></div>
    <div class="wave"></div>
  </div>
</div>

<!-- Right panel (login card) -->
<div class="right-panel">
  <div class="progress-bar"></div>
  <div class="corner-accent tl"></div>
  <div class="corner-accent br"></div>
  <div class="ring ring-1"></div>
  <div class="ring ring-2"></div>
  <div class="ring ring-3"></div>

  <div style="width:100%">
    <div class="card-eyebrow">Autentikasi Pengguna</div>
    <h2 class="card-title">Selamat Datang</h2>
    <p class="card-sub">Masukkan kredensial Anda untuk melanjutkan</p>

    <div class="form-group">
      <label class="form-label">User ID</label>
      <div class="input-wrap">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>
        <input type="email" id="emailInput" placeholder="userpusdatin@pu.go.id" />
        <div class="scan-line"></div>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Password</label>
      <div class="input-wrap">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        <input type="password" id="pwInput" placeholder="••••••••" />
        <button class="eye-btn" onclick="togglePw()" type="button">
          <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
        <div class="scan-line"></div>
      </div>
    </div>

    <button class="btn-masuk" id="btnMasuk" onclick="handleLogin(event)">
      <span class="btn-text">Masuk</span>
      <div class="btn-spinner"></div>
    </button>

    <div class="divider"><span>Bantuan</span></div>

    <div class="callcenter-box">
      <div class="cc-title">Call Center</div>
      <div class="cc-sub">Penilaian Transformasi Digital</div>
      <button class="cc-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.69h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.09a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
        0813-1689-9598
      </button>
      <button class="cc-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.69h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.09a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
        0819-3871-3429
      </button>
    </div>

    <p class="footer-text">
      © 2026 <strong>Laravel</strong> — Kementerian Pekerjaan Umum
    </p>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast">
  <div class="toast-dot"></div>
  <span id="toastMsg">Memproses...</span>
</div>

<script>
  // === Floating particles ===
  const container = document.getElementById('particles');
  const colors = ['#FDB813','#374773','#5a6fa8','#ffd04d'];
  for (let i = 0; i < 24; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    const size = Math.random() * 5 + 2;
    p.style.cssText = `
      width:${size}px; height:${size}px;
      left:${Math.random()*100}%;
      animation-duration:${Math.random()*15+10}s;
      animation-delay:${Math.random()*10}s;
      background:${colors[Math.floor(Math.random()*colors.length)]};
      opacity:0;
    `;
    container.appendChild(p);
  }

  // Geometric shapes
  for (let i = 0; i < 8; i++) {
    const g = document.createElement('div');
    g.className = 'geo-shape';
    const size = Math.random() * 20 + 8;
    const isSquare = Math.random() > 0.5;
    g.style.cssText = `
      width:${size}px; height:${size}px;
      left:${Math.random()*60}%;
      top:${Math.random()*100+50}%;
      border: 1.5px solid ${Math.random()>0.5?'rgba(253,184,19,0.4)':'rgba(55,71,115,0.3)'};
      border-radius:${isSquare?'2px':'50%'};
      animation-duration:${Math.random()*12+8}s;
      animation-delay:${Math.random()*8}s;
      transform: rotate(${Math.random()*180}deg);
    `;
    document.querySelector('.bg-canvas').appendChild(g);
  }

  // === Year counter ===
  const el = document.getElementById('counter-year');
  let start = 2018, end = 2024, dur = 1200;
  setTimeout(() => {
    const step = (end - start) / (dur / 16);
    let cur = start;
    const t = setInterval(() => {
      cur += step;
      if (cur >= end) { el.textContent = end; clearInterval(t); }
      else el.textContent = Math.floor(cur);
    }, 16);
  }, 1000);

  // === Typewriter for panel description ===
  const descText = "Platform terpadu pengelolaan data dan teknologi informasi untuk mendukung transformasi digital Kementerian Pekerjaan Umum.";
  const descEl = document.getElementById('typeDesc');
  let charIdx = 0;
  const cursor = document.createElement('span');
  cursor.className = 'cursor';
  descEl.appendChild(cursor);

  setTimeout(() => {
    const typeInterval = setInterval(() => {
      if (charIdx < descText.length) {
        descEl.insertBefore(document.createTextNode(descText[charIdx]), cursor);
        charIdx++;
      } else {
        clearInterval(typeInterval);
        setTimeout(() => { cursor.style.display = 'none'; }, 2000);
      }
    }, 28);
  }, 1200);

  // === Password toggle ===
  function togglePw() {
    const inp = document.getElementById('pwInput');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    const icon = document.getElementById('eyeIcon');
    if (inp.type === 'text') {
      icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    } else {
      icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    }
  }

  // === Button ripple + loading ===
  function handleLogin(e) {
    const btn = document.getElementById('btnMasuk');

    // Ripple
    const ripple = document.createElement('span');
    ripple.className = 'ripple';
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.cssText = `
      width:${size}px; height:${size}px;
      left:${e.clientX - rect.left - size/2}px;
      top:${e.clientY - rect.top - size/2}px;
    `;
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);

    // Loading state
    btn.classList.add('loading');
    showToast('Memverifikasi kredensial...');

    setTimeout(() => {
      btn.classList.remove('loading');
      showToast('Silakan periksa koneksi Anda', 2500);
    }, 2200);
  }

  // === Toast ===
  function showToast(msg, duration = 2000) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), duration);
  }

  // === Input shake on empty submit ===
  document.querySelectorAll('.input-wrap input').forEach(input => {
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        document.getElementById('btnMasuk').click();
      }
    });
  });
</script>
</body>
</html>