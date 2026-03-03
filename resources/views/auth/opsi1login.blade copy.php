<x-guest-layout>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- User ID --}}
        <div class="field">
            <label>User ID</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                <input type="text"
                       name="email"
                       value="{{ old('email') }}"
                       required autofocus
                       placeholder="Masukkan User ID">
            </div>
        </div>

        {{-- Password --}}
        <div class="field">
            <label>Password</label>
            <div class="input-wrap" id="pw-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </span>
                <input type="password"
                       id="pw-field"
                       name="password"
                       required
                       placeholder="Masukkan Password">
                <button type="button" class="toggle-pw"
                        onclick="var f=document.getElementById('pw-field');
                                 f.type=f.type==='password'?'text':'password';
                                 this.querySelector('.ico-eye').classList.toggle('hidden');
                                 this.querySelector('.ico-eye-off').classList.toggle('hidden');">
                    <svg class="ico-eye" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg class="ico-eye-off hidden" viewBox="0 0 24 24">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-submit">
            Masuk
        </button>

    </form>

    {{-- Divider --}}
    <div style="display:flex; align-items:center; gap:10px; margin:24px 0 20px;
                font-size:.63rem; font-weight:700; letter-spacing:.12em;
                text-transform:uppercase; color:#8893a8;">
        <div style="flex:1; height:1px; background:#e8ecf4;"></div>
        Bantuan
        <div style="flex:1; height:1px; background:#e8ecf4;"></div>
    </div>

    {{-- Call Center --}}
    <div style="background:#f7f8fc; border:1.5px solid #e8ecf4; border-radius:14px;
                padding:18px 20px; text-align:center;">
        <p style="font-size:.63rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase;
                  color:#374773; margin-bottom:4px;">Call Center</p>
        <p style="font-size:.77rem; font-weight:500; color:#5a6480; margin-bottom:14px;">
            Penilaian Transformasi Digital
        </p>
        <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
            <a href="tel:081316899598"
               style="display:inline-flex; align-items:center; gap:7px; padding:8px 16px;
                      background:#fff; border:1.5px solid #e8ecf4; border-radius:10px;
                      font-size:.78rem; font-weight:600; color:#374773; text-decoration:none;
                      box-shadow:0 1px 4px rgba(55,71,115,.07);
                      transition:border-color .2s, box-shadow .2s;"
               onmouseover="this.style.borderColor='#FDB813'; this.style.boxShadow='0 2px 8px rgba(253,184,19,.2)';"
               onmouseout="this.style.borderColor='#e8ecf4'; this.style.boxShadow='0 1px 4px rgba(55,71,115,.07)';">
                📱 0813-1689-9598
            </a>
            <a href="tel:081938713429"
               style="display:inline-flex; align-items:center; gap:7px; padding:8px 16px;
                      background:#fff; border:1.5px solid #e8ecf4; border-radius:10px;
                      font-size:.78rem; font-weight:600; color:#374773; text-decoration:none;
                      box-shadow:0 1px 4px rgba(55,71,115,.07);
                      transition:border-color .2s, box-shadow .2s;"
               onmouseover="this.style.borderColor='#FDB813'; this.style.boxShadow='0 2px 8px rgba(253,184,19,.2)';"
               onmouseout="this.style.borderColor='#e8ecf4'; this.style.boxShadow='0 1px 4px rgba(55,71,115,.07)';">
                📱 0819-3871-3429
            </a>
        </div>
    </div>

</x-guest-layout>