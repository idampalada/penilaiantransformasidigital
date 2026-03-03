<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Login — PUSDATIN Kementerian Pekerjaan Umum</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
KEMENTERIAN <br><span>PEKERJAAN UMUM</span>
    </div>
  </div>

  <div class="panel-eyebrow">PUSAT DATA TEKNOLOGI DAN INFORMASI</div>
  <h1 class="panel-title">
    Transformasi<br><span>Digital</span>
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
</div>

<!-- Right panel (login card) -->
<div class="right-panel">
  <div class="progress-bar"></div>
  <div class="corner-accent tl"></div>
  <div class="corner-accent br"></div>
  <div class="ring ring-1"></div>
  <div class="ring ring-2"></div>
  <div class="ring ring-3"></div>

  <!-- ===== FORM REAL LARAVEL (TANPA UBAH TAMPILAN) ===== -->
  <form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf

    <div style="width:100%">
      <div class="card-eyebrow">Autentikasi Pengguna</div>
      <h2 class="card-title">Selamat Datang</h2>
      <p class="card-sub">Masukkan kredensial Anda untuk melanjutkan</p>

      <!-- Error Laravel (tidak mengubah layout, hanya muncul jika ada error) -->
      @if ($errors->any())
        <div style="margin-bottom:14px; padding:10px 12px; border-radius:8px; background:rgba(220,38,38,0.1); color:#dc2626; font-size:13px;">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="form-group">
        <label class="form-label">User ID</label>
        <div class="input-wrap">
          <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
          <input type="email"
                 id="emailInput"
                 name="email"
                 value="{{ old('email') }}"
                 required
                 placeholder="userpusdatin@pu.go.id" />
          <div class="scan-line"></div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <div class="input-wrap">
          <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password"
                 id="pwInput"
                 name="password"
                 required
                 placeholder="••••••••" />
          <button class="eye-btn" onclick="togglePw()" type="button">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
          <div class="scan-line"></div>
        </div>
      </div>

      <!-- Button tetap sama tampilan & animasi -->
      <button type="button" class="btn-masuk" id="btnMasuk" onclick="handleLogin(event)">
        <span class="btn-text">Masuk</span>
        <div class="btn-spinner"></div>
      </button>

      <div class="divider"><span>Bantuan</span></div>

      <div class="callcenter-box">
        <div class="cc-title">Call Center</div>
        <div class="cc-sub">Penilaian Transformasi Digital</div>
        <button class="cc-btn" type="button">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.69h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.09a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
          0813-1689-9598
        </button>
        <button class="cc-btn" type="button">
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
  </form>
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
  let start = 2018, end = 2026, dur = 1200;
  setTimeout(() => {
    const step = (end - start) / (dur / 16);
    let cur = start;
    const t = setInterval(() => {
      cur += step;
      if (cur >= end) { el.textContent = end; clearInterval(t); }
      else el.textContent = Math.floor(cur);
    }, 16);
  }, 1000);

  // === Typewriter ===
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

  // === Button ripple + REAL submit ===
  function handleLogin(e) {
    e.preventDefault();
    const btn = document.getElementById('btnMasuk');
    const form = document.getElementById('loginForm');

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

    // Submit asli ke Laravel (tanpa mengubah tampilan)
    setTimeout(() => {
      form.submit();
    }, 800);
  }

  // === Toast ===
  function showToast(msg, duration = 2000) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), duration);
  }

  // === Enter key tetap jalan ===
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