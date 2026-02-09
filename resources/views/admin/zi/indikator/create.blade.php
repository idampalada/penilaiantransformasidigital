@extends('layouts.zi')

@section('content')

<div class="row">
    <div class="col-md-12">

        <h4><strong>Tambah Indikator ZI</strong></h4>
        <p class="text-muted">
            Admin menentukan struktur indikator (split / tidak split).
            UNOR hanya mengisi file & nilai.
        </p>

        <form method="POST" action="/admin/indikator">
            @csrf

            {{-- NO --}}
            <div class="form-group mb-3">
                <label>No</label>
                <input type="number"
                       name="nomor"
                       class="form-control"
                       required>
            </div>
{{-- KATEGORI --}}
<div class="form-group mb-3">
    <label>Kategori</label>
    <select name="kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="Organisasi">Organisasi</option>
        <option value="Proses">Proses</option>
        <option value="Data">Data</option>
        <option value="Teknologi">Teknologi</option>
    </select>

    <small class="text-muted">
        Digunakan untuk pengelompokan indikator (Organisasi / Proses / Data / Teknologi)
    </small>
</div>

            {{-- KRITERIA --}}
            <div class="form-group mb-3">
                <label>Kriteria</label>
                <textarea name="kriteria"
                          rows="2"
                          class="form-control"
                          required></textarea>
            </div>

            {{-- INDIKATOR --}}
            <div class="form-group mb-3">
                <label>Indikator</label>
                <textarea name="indikator"
                          rows="2"
                          class="form-control"
                          required></textarea>
            </div>

            {{-- KOMPONEN --}}
            <div class="form-group mb-4">
                <label>Komponen</label>
                <textarea name="komponen"
                          rows="3"
                          class="form-control"
                          required></textarea>

                <small class="text-muted d-block mt-1">
                    • Gunakan <code>||</code> jika komponen berbeda per metode<br>
                    • Jika sama untuk semua metode, cukup isi satu baris saja
                </small>
            </div>

            <hr>

            {{-- METODE --}}
            <div class="form-group mb-4">
                <label>Metode Pengukuran</label>
                <textarea name="metode_pengukuran"
                          rows="6"
                          class="form-control"
                          required></textarea>

                <small class="text-muted d-block mt-1">
                    <strong>Aturan:</strong><br>
                    • Gunakan <code>||</code> untuk MEMECAH metode (split baris sejajar)<br>
                    • Gunakan <code>;;</code> untuk baris baru di dalam 1 metode
                </small>
            </div>

            {{-- PENILAIAN --}}
            <div class="form-group mb-4">
                <label>Penilaian</label>
                <textarea name="penilaian"
                          rows="6"
                          class="form-control"
                          required></textarea>

                <small class="text-muted d-block mt-1">
                    <strong>PENTING:</strong><br>
                    • Jumlah <code>||</code> HARUS SAMA dengan Metode Pengukuran<br>
                    • Urutan split menentukan baris penilaian & file bukti
                </small>
            </div>

            {{-- BUKTI --}}
            <div class="form-group mb-4">
                <label>Bukti / Persyaratan</label>
                <textarea name="bukti_persyaratan"
                          rows="6"
                          class="form-control"
                          required></textarea>

                <small class="text-muted d-block mt-1">
                    • Boleh split (<code>||</code>) atau tidak<br>
                    • Jika split, jumlahnya IDEALNYA sama dengan Metode
                </small>
            </div>

            <div class="alert alert-info">
                <strong>Catatan Penting:</strong><br>
                Struktur split yang Anda buat di sini akan menentukan:
                <ul class="mb-0">
                    <li>Jumlah baris di landing UNOR</li>
                    <li>Jumlah upload file bukti</li>
                    <li>Struktur penilaian internal & eksternal</li>
                </ul>
            </div>

            <button class="btn btn-success">
                Simpan Indikator
            </button>

            <a href="/admin/indikator" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
