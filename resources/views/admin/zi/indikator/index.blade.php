@extends('layouts.zi')

@section('content')

<h4><strong>Tambah Indikator ZI</strong></h4>
<hr>

<form method="POST" action="/admin/indikator">
@csrf

<div class="row">
    <div class="col-md-2">
        <label>No</label>
        <input type="number" name="nomor" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label>Kriteria</label>
        <input type="text" name="kriteria" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label>Indikator</label>
        <input type="text" name="indikator" class="form-control" required>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-12">
        <label>Komponen</label>
        <input type="text" name="komponen" class="form-control" required>
    </div>
</div>

<hr>

<h5><strong>Metode & Penilaian</strong></h5>

<div id="metode-wrapper">

    <div class="panel panel-default metode-item">
        <div class="panel-body">

            <label>Metode Pengukuran</label>
            <textarea name="metode[]" class="form-control" rows="3" required></textarea>

            <br>

            <label>Penilaian (1 baris = 1 poin)</label>
            <textarea name="penilaian[]" class="form-control" rows="4" required></textarea>

        </div>
    </div>

</div>

<button type="button" class="btn btn-sm btn-info" onclick="addMetode()">
    + Tambah Metode
</button>

<hr>

<label>Bukti / Persyaratan</label>
<textarea name="bukti_persyaratan" class="form-control" rows="4" required></textarea>

<br>

<button class="btn btn-primary">Simpan Indikator</button>

</form>

<script>
function addMetode() {
    const wrapper = document.getElementById('metode-wrapper');

    const html = `
        <div class="panel panel-default metode-item">
            <div class="panel-body">
                <label>Metode Pengukuran</label>
                <textarea name="metode[]" class="form-control" rows="3" required></textarea>

                <br>

                <label>Penilaian (1 baris = 1 poin)</label>
                <textarea name="penilaian[]" class="form-control" rows="4" required></textarea>
            </div>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}
</script>

@endsection
