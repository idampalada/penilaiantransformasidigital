@extends('layouts.zi')

@section('content')

<div class="row">
<div class="col-md-12">

<h4><strong>LEMBAR KERJA EVALUASI ZONA INTEGRITAS (ZI)</strong></h4>
<p><strong>PUSAT DATA DAN TEKNOLOGI INFORMASI</strong></p>

<hr>

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
    <th>Nilai Internal</th>
    <th>Nilai Eksternal</th>
</tr>
</thead>

<tbody>

@php $currentKategori = null; @endphp

@foreach ($indikators as $item)

    {{-- ================= HEADER KATEGORI ================= --}}
    @if ($item->kategori !== $currentKategori)
        <tr class="zi-group-header">
            <td colspan="10"><strong>{{ strtoupper($item->kategori) }}</strong></td>
        </tr>
        @php $currentKategori = $item->kategori; @endphp
    @endif

    @php $firstItemRow = true; @endphp

    @foreach ($item->groups as $group)

        @foreach ($group['rows'] as $idx => $row)

        <tr>
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

            {{-- FILE --}}
            <td>
                <input type="file" class="form-control">
            </td>

            {{-- NILAI --}}
            @if ($firstItemRow)
                <td rowspan="{{ $item->total_rows }}" class="text-center align-middle">
                    <input class="form-control" disabled>
                </td>
                <td rowspan="{{ $item->total_rows }}" class="text-center align-middle">
                    <input class="form-control" disabled>
                </td>
            @endif
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

@endsection
