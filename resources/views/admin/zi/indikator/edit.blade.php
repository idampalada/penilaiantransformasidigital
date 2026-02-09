@extends('layouts.zi')

@section('content')

<div class="row">
    <div class="col-md-12">

        <h4><strong>Edit Indikator ZI</strong></h4>
        <p class="text-muted">
            Atur apakah indikator ini memiliki satu komponen atau multi-komponen.
        </p>

        <form method="POST" action="{{ route('admin.indikator.update', $indikator->id) }}">
            @csrf
            @method('PUT')

            {{-- ================= TOGGLE MULTI KOMPONEN ================= --}}
            <div class="form-group mb-3">
                <label class="d-block"><strong>Struktur Indikator</strong></label>

                <div class="form-check form-switch">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is_multi_komponen"
                        name="is_multi_komponen"
                        value="1"
                    >
                    <label class="form-check-label" for="is_multi_komponen">
                        Indikator ini <strong>memiliki lebih dari satu komponen</strong>
                    </label>
                </div>

                <small class="text-muted">
                    • OFF → 1 komponen, gunakan <code>;;</code> untuk anak<br>
                    • ON → Multi-komponen, gunakan <code>||</code> antar komponen
                </small>
            </div>

            <hr>

            {{-- ================= KOMPONEN ================= --}}
            <div class="form-group mb-3">
                <label><strong>Komponen</strong></label>
                <textarea
                    name="komponen"
                    id="field-komponen"
                    rows="4"
                    class="form-control"
                >{{ old('komponen', $indikator->komponen) }}</textarea>

                <small class="text-muted komponen-help">
                    Satu komponen saja (tidak perlu <code>||</code>)
                </small>
            </div>

            {{-- ================= METODE ================= --}}
            <div class="form-group mb-3">
                <label><strong>Metode Pengukuran</strong></label>
                <textarea
                    name="metode_pengukuran"
                    id="field-metode"
                    rows="6"
                    class="form-control"
                >{{ old('metode_pengukuran', $indikator->metode_pengukuran) }}</textarea>

                <small class="text-muted metode-help">
                    Gunakan <code>;;</code> untuk memisahkan metode
                </small>
            </div>

            {{-- ================= PENILAIAN ================= --}}
            <div class="form-group mb-3">
                <label><strong>Penilaian</strong></label>
                <textarea
                    name="penilaian"
                    id="field-penilaian"
                    rows="6"
                    class="form-control"
                >{{ old('penilaian', $indikator->penilaian) }}</textarea>

                <small class="text-muted penilaian-help">
                    Urutan <code>;;</code> harus sama dengan Metode
                </small>
            </div>

            {{-- ================= BUKTI ================= --}}
            <div class="form-group mb-4">
                <label><strong>Bukti / Persyaratan</strong></label>
                <textarea
                    name="bukti_persyaratan"
                    id="field-bukti"
                    rows="6"
                    class="form-control"
                >{{ old('bukti_persyaratan', $indikator->bukti_persyaratan) }}</textarea>

                <small class="text-muted bukti-help">
                    Sejajar dengan Metode & Penilaian
                </small>
            </div>

            <div class="alert alert-info" id="multiInfo" style="display:none">
                <strong>Mode Multi-Komponen AKTIF</strong><br>
                • Gunakan <code>||</code> untuk memisahkan komponen<br>
                • Gunakan <code>;;</code> untuk anak di dalam komponen
            </div>

            <button class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.indikator.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </form>

    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('is_multi_komponen');
    const info   = document.getElementById('multiInfo');

    const komponenHelp = document.querySelector('.komponen-help');
    const metodeHelp   = document.querySelector('.metode-help');

    function updateUI() {
        if (toggle.checked) {
            info.style.display = 'block';
            komponenHelp.innerHTML =
                'Gunakan <code>||</code> untuk memisahkan <strong>komponen</strong>';
            metodeHelp.innerHTML =
                'Gunakan <code>;;</code> di dalam komponen, <code>||</code> untuk pindah komponen';
        } else {
            info.style.display = 'none';
            komponenHelp.innerHTML =
                'Satu komponen saja (tidak perlu <code>||</code>)';
            metodeHelp.innerHTML =
                'Gunakan <code>;;</code> untuk memisahkan metode';
        }
    }

    toggle.addEventListener('change', updateUI);
    updateUI(); // init
});
</script>

@endsection
