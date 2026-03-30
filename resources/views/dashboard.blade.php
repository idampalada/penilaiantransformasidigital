@extends('layouts.unor')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap');

:root {
    --navy:        #1E3A5F;
    --navy-dark:   #152b47;
    --navy-light:  #e8edf5;
    --gold:        #F59E0B;
    --gold-dark:   #d97706;
    --gold-light:  #fef3c7;
    --text:        #1a2a42;
    --text-muted:  #64748b;
    --border:      #dde4ef;
    --surface:     #ffffff;
    --shadow:      0 4px 24px rgba(30, 58, 95, 0.09);
    --radius:      12px;
}

*, *::before, *::after { box-sizing: border-box; }

.rtp-wrapper {
    font-family: 'DM Sans', sans-serif;
    color: var(--text);
    width: 100%;
}

/* ── Heading ── */
.rtp-heading {
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: var(--navy);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    text-transform: uppercase;
}
.rtp-heading::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 20px;
    background: linear-gradient(180deg, var(--gold) 0%, var(--gold-dark) 100%);
    border-radius: 2px;
    flex-shrink: 0;
}

/* ── Filter ── */
.rtp-filter {
    margin-bottom: 18px;
}
.rtp-select {
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    font-size: 0.875rem;
    color: var(--text);
    background-color: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: 8px 36px 8px 14px;
    width: 200px !important;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%231E3A5F' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    box-shadow: 0 1px 4px rgba(30, 58, 95, 0.07);
    transition: border-color 0.2s, box-shadow 0.2s;
    cursor: pointer;
}
.rtp-select:focus {
    outline: none;
    border-color: var(--navy);
    box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12);
}

/* ── Table Card ── */
.rtp-card {
    background: var(--surface);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    border: 1.5px solid var(--border);
    animation: fadeUp 0.4s cubic-bezier(.22,1,.36,1) both;
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Table ── */
.rtp-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}

/* thead */
.rtp-table thead tr {
    background-color: var(--navy);
}
.rtp-table thead th {
    color: rgba(255,255,255,0.85);
    font-weight: 600;
    font-size: 0.7rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 14px 20px;
    border: none;
    white-space: nowrap;
}
.rtp-table thead th:first-child {
    border-left: 3px solid var(--gold);
    padding-left: 22px;
}

/* data rows */
.rtp-table tbody tr.rtp-data-row {
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
}
.rtp-table tbody tr.rtp-data-row:nth-child(even) { background: var(--navy-light); }
.rtp-table tbody tr.rtp-data-row:nth-child(odd)  { background: var(--surface); }
.rtp-table tbody tr.rtp-data-row:hover           { background: #d5dcea !important; }
.rtp-table tbody tr.rtp-data-row:last-child      { border-bottom: none; }

.rtp-table tbody td {
    padding: 12px 20px;
    font-size: 0.88rem;
    font-weight: 400;
    vertical-align: middle;
    border: none;
    color: var(--text);
}

/* ── Angka Total ── */
.rtp-total {
    font-weight: 700;
    font-size: 0.92rem;
    color: var(--navy);
    font-variant-numeric: tabular-nums;
}

/* ── Empty State ── */
.rtp-empty {
    text-align: center;
    padding: 48px;
    color: var(--text-muted);
    font-size: 0.9rem;
}

/* ═══════════════════════════════════════════
   GROUP HEADERS
   ═══════════════════════════════════════════ */

.rtp-group-header td {
    padding: 0 !important;
}

.rtp-group-label {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.rtp-group-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}

/* UNOR — Navy dalam */
.rtp-table tbody tr.rtp-group-unor {
    background: var(--navy) !important;
}
.rtp-table tbody tr.rtp-group-unor .rtp-group-label {
    color: #ffffff;
    border-left: 3px solid var(--gold);
}
.rtp-table tbody tr.rtp-group-unor .rtp-group-dot {
    background: var(--gold);
}

/* UNKER — Gold */
.rtp-table tbody tr.rtp-group-unker {
    background: var(--gold) !important;
}
.rtp-table tbody tr.rtp-group-unker .rtp-group-label {
    color: var(--navy-dark);
    border-left: 3px solid var(--navy);
}
.rtp-table tbody tr.rtp-group-unker .rtp-group-dot {
    background: var(--navy);
}

/* UPT — Abu biru dengan aksen navy */
.rtp-table tbody tr.rtp-group-upt {
    background: #c8d5e8 !important;
}
.rtp-table tbody tr.rtp-group-upt .rtp-group-label {
    color: var(--navy);
    border-left: 3px solid var(--navy);
}
.rtp-table tbody tr.rtp-group-upt .rtp-group-dot {
    background: var(--navy);
    opacity: 0.5;
}

/* ═══════════════════════════════════════════
   POPUP NOTICE
   ═══════════════════════════════════════════ */
.notice-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 28, 50, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(3px);
}

.notice-box {
    background: white;
    width: 420px;
    max-width: 90%;
    padding: 32px 28px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(15, 28, 50, 0.25);
    font-family: 'DM Sans', sans-serif;
    border-top: 4px solid var(--gold);
}

.notice-icon {
    width: 44px;
    height: 44px;
    background: var(--gold-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 1.2rem;
}

.notice-box h3 {
    color: var(--navy);
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 10px;
    letter-spacing: 0.02em;
}

.notice-box p {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.7;
    margin: 0;
}

.notice-box button {
    margin-top: 22px;
    background: var(--navy);
    color: white;
    border: none;
    padding: 11px 28px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    letter-spacing: 0.02em;
    transition: background 0.2s, transform 0.1s;
}
.notice-box button:hover  { background: var(--navy-dark); }
.notice-box button:active { transform: scale(0.98); }

/* ── Login Button ── */
.rtp-btn-login {
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: 0.875rem;
    color: #ffffff;
    background: var(--navy);
    border: none;
    border-radius: 8px;
    padding: 9px 20px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    letter-spacing: 0.02em;
    transition: background 0.2s, transform 0.1s;
    white-space: nowrap;
}
.rtp-btn-login::before {
    content: '';
    display: inline-block;
    width: 14px;
    height: 14px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-size: contain;
}
.rtp-btn-login:hover  { background: var(--navy-dark); }
.rtp-btn-login:active { transform: scale(0.97); }
</style>

<div class="rtp-wrapper">

    <!-- Top: Logo -->
<div style="display:flex; align-items:center; gap:14px; margin-top:20px; margin-bottom:20px;">
        <img src="/favicon.ico" style="width:48px; height:48px; object-fit:contain;">
        <div>
            <p style="margin:0; font-size:1.28rem; font-weight:700; color:#1E3A5F; letter-spacing:0.1em; line-height:1.4;">KEMENTERIAN</p>
            <p style="margin:0; font-size:1.28rem; font-weight:700; color:#1E3A5F; letter-spacing:0.1em; line-height:1.4;">PEKERJAAN UMUM</p>
        </div>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 class="rtp-heading" style="margin-bottom:0;">Real Time Penilaian Transformasi Digital</h3>
        <div style="display:flex; align-items:center; gap:12px;">
            <form method="GET" class="rtp-filter" style="margin-bottom:0;">
                <select name="jenis" onchange="this.form.submit()" class="rtp-select">
                    <option value="">-- Semua --</option>
                    <option value="UNOR"  {{ ($jenis ?? '') == 'UNOR'  ? 'selected' : '' }}>UNIT ORGANISASI</option>
                    <option value="UNKER" {{ ($jenis ?? '') == 'UNKER' ? 'selected' : '' }}>UNIT KERJA</option>
                    <option value="UPT"   {{ ($jenis ?? '') == 'UPT'   ? 'selected' : '' }}>UNIT PELAKSANA TEKNIS</option>
                </select>
            </form>
            <a href="/login" class="rtp-btn-login">Login</a>
        </div>
    </div>

    <div class="rtp-card">
        <table class="rtp-table">
            <thead>
                <tr>
                    <th style="width:56px;">No</th>
                    <th>Nama Unit</th>
                    <th>Jumlah Pengukuran</th>
                    <th>Jumlah Bukti Dukung Terupload</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grouped = collect($data)->groupBy('jenis');
                    $labelMap = [
                        'UNOR'  => 'Unit Organisasi',
                        'UNKER' => 'Unit Kerja',
                        'UPT'   => 'Unit Pelaksana Teknis',
                    ];
                @endphp

                @forelse($grouped as $jenis => $items)

                    {{-- GROUP HEADER --}}
                    @php
                        $cls = match($jenis) {
                            'UNOR'  => 'rtp-group-unor',
                            'UNKER' => 'rtp-group-unker',
                            default => 'rtp-group-upt',
                        };
                    @endphp
                    <tr class="rtp-group-header {{ $cls }}">
                        <td colspan="4">
                            <div class="rtp-group-label">
                                <span class="rtp-group-dot"></span>
                                {{ $labelMap[$jenis] ?? $jenis }}
                            </div>
                        </td>
                    </tr>

                    {{-- DATA ROWS --}}
                    @php $no = 1; @endphp
                    @foreach($items as $row)
                    <tr class="rtp-data-row">
                        <td style="color:var(--text-muted);font-size:0.82rem;">{{ $no++ }}</td>
                        <td>{{ $row->nama }}</td>
                        <td class="rtp-total">{{ $row->total_penilaian }}</td>
                        <td class="rtp-total">{{ $row->total_bukti }}</td>
                    </tr>
                    @endforeach

                @empty
                    <tr>
                        <td colspan="4" class="rtp-empty">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- POPUP NOTICE --}}
<div id="noticePopup" class="notice-overlay">
    <div class="notice-box">
        <div class="notice-icon">📋</div>
        <h3>Pemberitahuan</h3>
        <p>
            Penilaian Transformasi Digital akan dilaksanakan pada
            <strong>19 Desember 2026</strong>.
            <br><br>
            Setiap unit diharapkan segera melengkapi seluruh indikator
            beserta bukti dukung yang diperlukan.
        </p>
        <button onclick="closeNotice()">Mengerti</button>
    </div>
</div>

<script>
function closeNotice() {
    document.getElementById('noticePopup').style.display = 'none';
}
</script>

@endsection