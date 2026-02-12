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

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul style="margin:0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

@php
$kategoriTotals = [];

foreach ($indikators as $it) {
    $kat = strtoupper($it->kategori);

    if (!isset($kategoriTotals[$kat])) {
        $kategoriTotals[$kat] = [
            'mandiri' => 0,
            'tahap1'  => 0,
            'tahap2'  => 0,
        ];
    }

    $kategoriTotals[$kat]['mandiri'] += floatval($it->penilaian_mandiri ?? 0);
    $kategoriTotals[$kat]['tahap1']  += floatval($it->penilaian_tahap_1 ?? 0);
    $kategoriTotals[$kat]['tahap2']  += floatval($it->penilaian_tahap_2 ?? 0);
}
@endphp

@php
$kategoriTotals = [];

$grandTotal = [
    'mandiri' => 0,
    'tahap1'  => 0,
    'tahap2'  => 0,
];

foreach ($indikators as $it) {
    $kat = strtoupper($it->kategori);

    if (!isset($kategoriTotals[$kat])) {
        $kategoriTotals[$kat] = [
            'mandiri' => 0,
            'tahap1'  => 0,
            'tahap2'  => 0,
        ];
    }

    $mandiri = floatval($it->penilaian_mandiri ?? 0);
    $t1      = floatval($it->penilaian_tahap_1 ?? 0);
    $t2      = floatval($it->penilaian_tahap_2 ?? 0);

    // total per kategori
    $kategoriTotals[$kat]['mandiri'] += $mandiri;
    $kategoriTotals[$kat]['tahap1']  += $t1;
    $kategoriTotals[$kat]['tahap2']  += $t2;

    // TOTAL KESELURUHAN
    $grandTotal['mandiri'] += $mandiri;
    $grandTotal['tahap1']  += $t1;
    $grandTotal['tahap2']  += $t2;
}
@endphp

<div class="table-responsive">

<form action="{{ route('zi.bukti.upload') }}"
      method="POST"
      enctype="multipart/form-data">
@csrf


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
    <th>File Bukti 1</th>
    <th>Penilaian Mandiri</th>
    <th>Penilaian Tahap 1</th>
    <th>Note Penilaian 1</th>
    <th>File Bukti 2</th>
    <th>Penilaian Tahap 2</th>
    <th>Note Penilaian 2</th>
</tr>
</thead>


<tbody>

@php $currentKategori = null; @endphp

@foreach ($indikators as $item)

    {{-- ================= HEADER KATEGORI ================= --}}
@if ($item->kategori !== $currentKategori)

@php
    $kat = strtoupper($item->kategori);
@endphp

<tr class="zi-group-header" data-kategori="{{ $kat }}">
    <td colspan="14"><strong>{{ $kat }}</strong></td>
</tr>

<tr class="zi-total-kategori">
    <td colspan="8" class="text-right">
        <strong>TOTAL {{ $kat }}</strong>
    </td>
    <td>
        <strong>{{ number_format($kategoriTotals[$kat]['mandiri'], 2) }}</strong>
    </td>
    <td>
        <strong>{{ number_format($kategoriTotals[$kat]['tahap1'], 2) }}</strong>
    </td>
    <td></td>
    <td></td>
    <td>
        <strong>{{ number_format($kategoriTotals[$kat]['tahap2'], 2) }}</strong>
    </td>
    <td></td>
</tr>

@php
    $currentKategori = $item->kategori;
@endphp
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
    <input type="file"
           name="file_bukti_1[{{ $item->id }}]"
           accept="application/pdf"
           class="form-control input-sm zi-file-input">

    @if($item->file_bukti_1)
        <div style="margin-top:4px; font-size:11px;">
            📄
            <a href="{{ asset('storage/' . $item->file_bukti_1) }}"
               target="_blank">
                {{ basename($item->file_bukti_1) }}
            </a>
        </div>
    @endif
</td>


    {{-- PENILAIAN MANDIRI --}}
    <td>
<input type="number"
       name="penilaian_mandiri[{{ $item->id }}]"
       min="0"
       max="1"
       step="0.01"
       value="{{ old('penilaian_mandiri.' . $item->id, $item->penilaian_mandiri) }}"
       class="form-control input-sm"
       placeholder="0 - 1">

    </td>

    {{-- PENILAIAN TAHAP 1 --}}
    <td>
<input type="number"
       name="penilaian_tahap_1[{{ $item->id }}]"
       min="0"
       max="1"
       step="0.01"
       value="{{ old('penilaian_tahap_1.' . $item->id, $item->penilaian_tahap_1) }}"
       class="form-control input-sm"
       placeholder="0 - 1">

    </td>

    {{-- NOTE PENILAIAN 1 --}}
    <td>
<textarea name="note_penilaian_1[{{ $item->id }}]"
          class="form-control input-sm"
          rows="2"
          placeholder="Catatan Penilaian 1">{{ old('note_penilaian_1.' . $item->id, $item->note_penilaian_1) }}</textarea>

    </td>


{{-- BUKTI FILE 2 --}}
<td>
    <input type="file"
           name="file_bukti_2[{{ $item->id }}]"
           accept="application/pdf"
           class="form-control input-sm zi-file-input">

    @if($item->file_bukti_2)
        <div style="margin-top:4px; font-size:11px;">
            📄
            <a href="{{ asset('storage/' . $item->file_bukti_2) }}"
               target="_blank">
                {{ basename($item->file_bukti_2) }}
            </a>
        </div>
    @endif
</td>



    {{-- PENILAIAN TAHAP 2 --}}
    <td>
<input type="number"
       name="penilaian_tahap_2[{{ $item->id }}]"
       min="0"
       max="1"
       step="0.01"
       value="{{ old('penilaian_tahap_2.' . $item->id, $item->penilaian_tahap_2) }}"
       class="form-control input-sm"
       placeholder="0 - 1">

    </td>

    {{-- NOTE PENILAIAN 2 --}}
    <td>
<textarea name="note_penilaian_2[{{ $item->id }}]"
          class="form-control input-sm"
          rows="2"
          placeholder="Catatan Penilaian 2">{{ old('note_penilaian_2.' . $item->id, $item->note_penilaian_2) }}</textarea>

    </td>

</tr>

@php $firstItemRow = false; @endphp

@endforeach
@endforeach
@endforeach
<tr class="zi-grand-total">
    <td colspan="8" class="text-right">
        <strong>TOTAL KESELURUHAN</strong>
    </td>
    <td>
        <strong>{{ number_format($grandTotal['mandiri'], 2) }}</strong>
    </td>
    <td>
        <strong>{{ number_format($grandTotal['tahap1'], 2) }}</strong>
    </td>
    <td></td>
    <td></td>
    <td>
        <strong>{{ number_format($grandTotal['tahap2'], 2) }}</strong>
    </td>
    <td></td>
</tr>

</tbody>

</table>


<div class="text-end mt-3">
    <button type="submit" class="btn btn-primary">
        Simpan
    </button>
</div>

</form>
</div>

</div>
</div>

@endsection
