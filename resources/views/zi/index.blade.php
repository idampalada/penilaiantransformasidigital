@extends('layouts.zi')

@section('content')

<div class="row">
<div class="col-md-12">

<h4><strong>PENILAIAN TRANSFORMASI DIGITAL</strong></h4>
<p><strong>PUSAT DATA DAN TEKNOLOGI INFORMASI</strong></p>
@if(Auth::check())
    <div class="row" style="margin-bottom:15px;">
        <div class="col-md-12">
            <div class="well well-sm" style="padding:8px 12px;">
                <div class="pull-left">
                    👤 <strong>{{ Auth::user()->name }}</strong>
                    <span class="text-muted">
                        | Role: {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>

                <div class="pull-right">
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-xs">
                            Logout
                        </button>
                    </form>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endif


<hr>
<div class="row" style="margin-bottom:10px;">
    <div class="col-md-3">
        <select id="filterKategori" class="form-control input-sm">
            <option value="all">Keseluruhan</option>
            <option value="PROSES">Proses</option>
            <option value="ORGANISASI">Organisasi</option>
            <option value="TEKNOLOGI">Teknologi</option>
            <option value="DATA">Data</option>
        </select>
    </div>
</div>

<div class="table-responsive">
<table class="table table-bordered zi-table">

<thead>
<tr>
    <th>No</th>
    <th>Kriteria</th>
    <th>Indikator</th>
    <th>Komponen</th>
    <th>Metode Pengukuran</th>
    <th>Penilaian</th>
    <th>Bukti / Persyaratan</th>
    <th>File Bukti</th>
    <th>Penilaian Mandiri</th>
    <th>Penilaian Tahap 1</th>
    <th>Note Penilaian 1</th>
    <th>Penilaian Tahap 2</th>
    <th>Note Penilaian 2</th>
</tr>
</thead>


<tbody>

@php $currentKategori = null; @endphp

@foreach ($indikators as $item)

    {{-- ================= HEADER KATEGORI ================= --}}
@if ($item->kategori !== $currentKategori)
<tr class="zi-group-header" data-kategori="{{ strtoupper($item->kategori) }}">
    <td colspan="13"><strong>{{ strtoupper($item->kategori) }}</strong></td>
</tr>
    @php $currentKategori = $item->kategori; @endphp
@endif

@php $firstItemRow = true; @endphp

@foreach ($item->groups as $group)
@foreach ($group['rows'] as $idx => $row)

<tr class="zi-row" data-kategori="{{ strtoupper($item->kategori) }}">

    {{-- NO / KRITERIA / INDIKATOR --}}
    @if ($firstItemRow)
        <td rowspan="{{ $item->total_rows }}" class="text-center align-middle">
            {{ $item->nomor }}
        </td>
        <td rowspan="{{ $item->total_rows }}" class="align-middle">
            {{ $item->kriteria }}
        </td>
        <td rowspan="{{ $item->total_rows }}" class="align-middle">
            {{ $item->indikator }}
        </td>
    @endif

    {{-- KOMPONEN --}}
    @if ($idx === 0)
        <td rowspan="{{ $group['rowspan'] }}" class="align-middle">
            {{ $group['komponen'] }}
        </td>
    @endif

    {{-- METODE --}}
    <td>{!! nl2br(e($row['metode'])) !!}</td>

    {{-- PENILAIAN --}}
    <td>{!! nl2br(e($row['penilaian'])) !!}</td>

    {{-- BUKTI --}}
    <td>{!! nl2br(e($row['bukti'])) !!}</td>

    {{-- FILE BUKTI --}}
    <td>
        <input type="file" class="form-control input-sm">
    </td>

    {{-- PENILAIAN MANDIRI --}}
    <td>
        <input
            type="number"
            min="0"
            max="1"
            step="0.1"
            class="form-control input-sm"
            placeholder="0 - 1">
    </td>

    {{-- PENILAIAN TAHAP 1 --}}
    <td>
        <input
            type="number"
            min="0"
            max="1"
            step="0.1"
            class="form-control input-sm"
            placeholder="0 - 1">
    </td>

    {{-- NOTE PENILAIAN 1 --}}
    <td>
        <textarea
            class="form-control input-sm"
            rows="2"
            placeholder="Catatan Penilaian 1"></textarea>
    </td>

    {{-- PENILAIAN TAHAP 2 --}}
    <td>
        <input
            type="number"
            min="0"
            max="1"
            step="0.1"
            class="form-control input-sm"
            placeholder="0 - 1">
    </td>

    {{-- NOTE PENILAIAN 2 --}}
    <td>
        <textarea
            class="form-control input-sm"
            rows="2"
            placeholder="Catatan Penilaian 2"></textarea>
    </td>

</tr>

@php $firstItemRow = false; @endphp

@endforeach
@endforeach
@endforeach


</tbody>

</table>
</div>

</div>
</div>
<script>
document.getElementById('filterKategori').addEventListener('change', function () {
    var selected = this.value;

    var headers = document.querySelectorAll('.zi-group-header');
    var rows = document.querySelectorAll('.zi-row');

    if (selected === 'all') {
        headers.forEach(el => el.style.display = '');
        rows.forEach(el => el.style.display = '');
        return;
    }

    headers.forEach(function (el) {
        el.style.display =
            el.getAttribute('data-kategori') === selected ? '' : 'none';
    });

    rows.forEach(function (el) {
        el.style.display =
            el.getAttribute('data-kategori') === selected ? '' : 'none';
    });
});
</script>

@endsection
