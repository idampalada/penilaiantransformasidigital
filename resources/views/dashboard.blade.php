@extends('layouts.unor')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

:root {
    --navy:        #374773;
    --navy-dark:   #273459;
    --navy-light:  #eef0f6;
    --gold:        #FDB813;
    --gold-dark:   #e6a20e;
    --text:        #1f2d4e;
    --text-muted:  #6b7a99;
    --border:      #dde2ef;
    --surface:     #ffffff;
    --shadow:      0 2px 20px rgba(55, 71, 115, 0.10);
    --radius:      10px;
}

.rtp-wrapper {
    font-family: 'DM Sans', sans-serif;
    color: var(--text);
}

/* ── Heading ── */
.rtp-heading {
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    color: var(--navy);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.rtp-heading::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 22px;
    background: linear-gradient(180deg, var(--gold) 0%, var(--gold-dark) 100%);
    border-radius: 3px;
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
    padding: 8px 36px 8px 12px;
    width: 200px !important;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%23374773' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 11px center;
    box-shadow: 0 1px 4px rgba(55,71,115,0.07);
    transition: border-color 0.2s, box-shadow 0.2s;
    cursor: pointer;
}
.rtp-select:focus {
    outline: none;
    border-color: var(--navy);
    box-shadow: 0 0 0 3px rgba(55,71,115,0.12);
}

/* ── Table Card ── */
.rtp-card {
    background: var(--surface);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    border: 1.5px solid var(--border);
    animation: fadeUp 0.35s cubic-bezier(.22,1,.36,1) both;
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Table ── */
.rtp-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}

.rtp-table thead tr {
    background-color: var(--navy);
}
.rtp-table thead th {
    color: #ffffff;
    font-weight: 600;
    font-size: 0.775rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 13px 18px;
    border: none;
    white-space: nowrap;
}
.rtp-table thead th:first-child {
    border-left: 4px solid var(--gold);
}

.rtp-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background 0.13s;
}
.rtp-table tbody tr:nth-child(odd)  { background: var(--navy-light); }
.rtp-table tbody tr:nth-child(even) { background: var(--surface); }
.rtp-table tbody tr:hover           { background: #dde2ef !important; }
.rtp-table tbody tr:last-child      { border-bottom: none; }

.rtp-table tbody td {
    padding: 12px 18px;
    font-size: 0.9rem;
    font-weight: 400;
    vertical-align: middle;
    border: none;
    color: var(--text);
}

/* ── Badge Jenis ── */
.badge-jenis {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 0.71rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.badge-unor  { background: var(--navy);       color: #ffffff; }
.badge-unker { background: var(--gold);       color: var(--navy-dark); }
.badge-upt   { background: var(--navy-light); color: var(--navy); border: 1px solid var(--border); }

/* ── Angka Total ── */
.rtp-total {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--navy);
}

/* ── Empty State ── */
.rtp-empty {
    text-align: center;
    padding: 40px;
    color: var(--text-muted);
    font-size: 0.9rem;
}

/* POPUP NOTICE */
.notice-overlay{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.notice-box{
    background: white;
    width: 420px;
    max-width: 90%;
    padding: 28px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 10px 35px rgba(0,0,0,0.2);
    font-family: 'DM Sans', sans-serif;
}

.notice-box h3{
    color: var(--navy);
    font-weight: 700;
    margin-bottom: 10px;
}

.notice-box p{
    font-size: 0.95rem;
    color: var(--text-muted);
    line-height: 1.6;
}

.notice-box button{
    margin-top: 18px;
    background: var(--navy);
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

.notice-box button:hover{
    background: var(--navy-dark);
}
</style>

<div class="rtp-wrapper">

    <h3 class="rtp-heading">REAL TIME PENILAIAN</h3>

    <form method="GET" class="rtp-filter">
        <select name="jenis" onchange="this.form.submit()" class="rtp-select">
            <option value="">-- Semua --</option>
            <option value="UNOR"  {{ ($jenis ?? '') == 'UNOR'  ? 'selected' : '' }}>UNOR</option>
            <option value="UNKER" {{ ($jenis ?? '') == 'UNKER' ? 'selected' : '' }}>UNKER</option>
            <option value="UPT"   {{ ($jenis ?? '') == 'UPT'   ? 'selected' : '' }}>UPT</option>
        </select>
    </form>

    <div class="rtp-card">
        <table class="rtp-table">
            <thead>
                <tr>
                    <th>Jenis Unit</th>
                    <th>Nama Unit</th>
                    <th>Jumlah Pengukuran</th>
                    <th>Jumlah Bukti Dukung Terupload</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                <tr>
                    <td>
                        <span class="badge-jenis badge-{{ strtolower($row->jenis) }}">
                            {{ $row->jenis }}
                        </span>
                    </td>
                    <td>{{ $row->nama }}</td>
                    <td class="rtp-total">{{ $row->total_penilaian }}</td>
                    <td class="rtp-total">{{ $row->total_bukti }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="rtp-empty">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- POPUP NOTICE -->
<div id="noticePopup" class="notice-overlay">
    <div class="notice-box">
        <h3>Pemberitahuan</h3>
        <p>
            Penilaian Transformasi Digital akan dilaksanakan pada 
            <strong>19 Desember 2026</strong>. 
            <br><br>
            Setiap unit diharapkan untuk segera melengkapi seluruh indikator 
            yang tersedia beserta bukti dukung yang diperlukan.
        </p>

        <button onclick="closeNotice()">Mengerti</button>
    </div>
</div>
<script>
function closeNotice(){
    document.getElementById("noticePopup").style.display = "none";
}
</script>
@endsection