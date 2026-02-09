@extends('layouts.zi')

@section('content')

<div class="row">
<div class="col-md-12">

<h4><strong>LEMBAR KERJA EVALUASI ZONA INTEGRITAS (ZI)</strong></h4>
<p><strong>PUSAT DATA DAN TEKNOLOGI INFORMASI</strong></p>

<hr>

<div class="table-responsive">
<table class="table table-bordered zi-table">

<colgroup>
    <col style="width:50px">
    <col style="width:140px">
    <col style="width:180px">
    <col style="width:180px">
    <col style="width:260px">
    <col style="width:260px">
    <col style="width:260px">
    <col style="width:160px">
    <col style="width:120px">
    <col style="width:120px">
</colgroup>

<thead>
<tr>
    <th>No</th>
    <th>Kriteria</th>
    <th>Indikator</th>
    <th>Komponen</th>
    <th>Metode</th>
    <th>Penilaian</th>
    <th>Bukti / Persyaratan</th>
    <th>File Bukti</th>
    <th>Nilai Internal</th>
    <th>Nilai Eksternal</th>
</tr>
</thead>

<tbody>
@foreach ($indikators as $item)

@php
    $metodes    = str_contains($item->metode_pengukuran, '||')
                    ? explode('||', $item->metode_pengukuran)
                    : [$item->metode_pengukuran];

    $penilaians = str_contains($item->penilaian, '||')
                    ? explode('||', $item->penilaian)
                    : [$item->penilaian];

    $buktis     = str_contains($item->bukti_persyaratan, '||')
                    ? explode('||', $item->bukti_persyaratan)
                    : [$item->bukti_persyaratan];

    $rows = max(count($metodes), count($penilaians), count($buktis));
@endphp

@for ($i = 0; $i < $rows; $i++)
<tr>
    @if ($i === 0)
        <td rowspan="{{ $rows }}" class="text-center">{{ $item->nomor }}</td>
        <td rowspan="{{ $rows }}">{{ $item->kriteria }}</td>
        <td rowspan="{{ $rows }}">{{ $item->indikator }}</td>
        <td rowspan="{{ $rows }}">{{ $item->komponen }}</td>
    @endif

    <td>
        {!! nl2br(e(str_replace(';;', "\n", $metodes[$i] ?? ''))) !!}
    </td>

    <td>
        {!! nl2br(e(str_replace(';;', "\n", $penilaians[$i] ?? ''))) !!}
    </td>

    <td>
        {!! nl2br(e(str_replace(';;', "\n", $buktis[$i] ?? ''))) !!}
    </td>

    <td>
        <input type="file" class="form-control zi-file-input">
    </td>

    @if ($i === 0)
        <td rowspan="{{ $rows }}" class="text-center">
            <input class="form-control zi-input" disabled>
        </td>
        <td rowspan="{{ $rows }}" class="text-center">
            <input class="form-control zi-input" disabled>
        </td>
    @endif
</tr>
@endfor

@endforeach
</tbody>

</table>
</div>

</div>
</div>

@endsection
