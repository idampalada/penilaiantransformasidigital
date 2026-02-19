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
        | Role: {{ ucfirst(Auth::user()->role->name) }}
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

{{-- ================= ROLE LOGIC ================= --}}
@php
$roleId = auth()->user()->role_id;

$showTahap1     = false;
$showFileBukti2 = false;
$showTahap2     = false;

// Role 1 dan 3: semua kolom always on
if (in_array($roleId, [1, 3])) {
    $showTahap1     = true;
    $showFileBukti2 = true;
    $showTahap2     = true;
} else {
    // Role 2 (user biasa): tampil sesuai kondisi data
    foreach ($indikators as $it) {
        // Tahap 1 tampil jika sudah ada nilai
        if (!is_null($it->unit_penilaian->penilaian_tahap_1))
 {
            $showTahap1 = true;
        }
        // File Bukti 2 muncul kalau tahap 1 sudah dinilai
        if (!is_null($it->unit_penilaian->penilaian_tahap_1))
 {
            $showFileBukti2 = true;
        }
        // Tahap 2 tampil kalau sudah ada nilai tahap 2
if (!is_null($it->unit_penilaian->penilaian_tahap_2)) {
    $showTahap2 = true;
}

    }
}

// Hitung total columns untuk colspan
$baseColumns = 9; // No, Kriteria, Indikator, Komponen, Metode, Penilaian, Bukti, FileBukti1, PenilaianMandiri
$extraColumns = 0;
if ($showTahap1)     $extraColumns += 2; // Penilaian Tahap 1 + Note 1
if ($showFileBukti2) $extraColumns += 1; // File Bukti 2
if ($showTahap2)     $extraColumns += 2; // Penilaian Tahap 2 + Note 2

if ($roleId == 1) {
    $extraColumns += 1; // kolom Opsi Nilai
}
$totalColumns = $baseColumns + $extraColumns;
@endphp

{{-- ================= HITUNG TOTAL KATEGORI & GRAND TOTAL ================= --}}
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
        $kategoriTotals[$kat] = ['mandiri' => 0, 'tahap1' => 0, 'tahap2' => 0];
    }

$mandiri = floatval($it->unit_penilaian->penilaian_mandiri ?? 0);
$t1      = floatval($it->unit_penilaian->penilaian_tahap_1 ?? 0);
$t2      = floatval($it->unit_penilaian->penilaian_tahap_2 ?? 0);

    $kategoriTotals[$kat]['mandiri'] += $mandiri;
    $kategoriTotals[$kat]['tahap1']  += $t1;
    $kategoriTotals[$kat]['tahap2']  += $t2;

    $grandTotal['mandiri'] += $mandiri;
    $grandTotal['tahap1']  += $t1;
    $grandTotal['tahap2']  += $t2;
}
@endphp

{{-- ================= FILTER KATEGORI ================= --}}
<form action="{{ route('zi.bukti.upload') }}"
      method="POST"
      enctype="multipart/form-data">
@csrf

<div class="text-right" style="margin-bottom:15px;">
    <button type="submit" class="btn btn-primary">
        Simpan
    </button>
</div>
<div class="row" style="margin-bottom:15px;">
    <div class="col-md-3">

        <label style="font-weight:600; margin-bottom:5px;">
            KRITERIA KATEGORI
        </label>
        <select id="filterKategori" class="form-control input-sm">
            <option value="all">Keseluruhan</option>
            <option value="PROSES">Proses</option>
            <option value="ORGANISASI">Organisasi</option>
            <option value="TEKNOLOGI">Teknologi</option>
            <option value="DATA">Data</option>
        </select>
    </div>
</div>



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

@if($showTahap1)
    <th>Penilaian Tahap 1</th>
    <th>Note Penilaian 1</th>
@endif

@if($showFileBukti2)
    <th>File Bukti 2</th>
@endif

@if($showTahap2)
    <th>Penilaian Tahap 2</th>
    <th>Note Penilaian 2</th>
@endif


@if($roleId == 1)
    <th>Opsi Nilai</th>
@endif

</tr>
</thead>

<tbody>

@php $currentKategori = null; @endphp

@foreach ($indikators as $item)

@if ($item->kategori !== $currentKategori)

@php $kat = strtoupper($item->kategori); @endphp

<tr class="zi-group-header" data-kategori="{{ $kat }}">
    <td colspan="{{ $totalColumns }}"><strong>{{ $kat }}</strong></td>
</tr>

{{-- TOTAL PER KATEGORI --}}
<tr class="zi-total-kategori" data-kategori="{{ $kat }}">
    <td colspan="8" class="text-right">
        <strong>TOTAL {{ $kat }}</strong>
    </td>
    <td>
        <strong>{{ number_format($kategoriTotals[$kat]['mandiri'], 2) }}</strong>
    </td>

    @if($showTahap1)
        <td>
            <strong>{{ number_format($kategoriTotals[$kat]['tahap1'], 2) }}</strong>
        </td>
        <td></td>
    @endif

    @if($showFileBukti2)
        <td></td>
    @endif

    @if($showTahap2)
        <td>
            <strong>{{ number_format($kategoriTotals[$kat]['tahap2'], 2) }}</strong>
        </td>
        <td></td>
    @endif

    @if($roleId == 1)
    <td></td>
@endif

</tr>

@php $currentKategori = $item->kategori; @endphp
@endif

@php $firstItemRow = true; @endphp

@foreach ($item->groups as $group)
@foreach ($group['rows'] as $idx => $row)

<tr class="zi-row" data-kategori="{{ strtoupper($item->kategori) }}">

@if ($firstItemRow)
    <td rowspan="{{ $item->total_rows }}">{{ $item->nomor }}</td>
    <td rowspan="{{ $item->total_rows }}">{{ $item->kriteria }}</td>
    <td rowspan="{{ $item->total_rows }}">{{ $item->indikator }}</td>
@endif

@if ($idx === 0)
    <td rowspan="{{ $group['rowspan'] }}">{{ $group['komponen'] }}</td>
@endif

<td>{!! nl2br(e($row['metode'])) !!}</td>
<td>{!! nl2br(e($row['penilaian'])) !!}</td>
<td>{!! nl2br(e($row['bukti'])) !!}</td>

{{-- FILE BUKTI 1 — hanya role 2 yang boleh upload & hapus --}}
<td>
<input type="file"
       name="file_bukti_1[{{ $item->id }}][]"
       accept="application/pdf"
       multiple
       class="form-control input-sm"
       @if($roleId != 2 && $roleId != 1) disabled @endif>

<small class="text-muted">
    * Format wajib PDF, maksimal 25MB per file
</small>

    @foreach($item->bukti->where('metode_index', 1) as $file)
        <div style="margin-top:4px; font-size:11px;">
            📄
<a href="{{ asset('storage/' . $file->file_path) }}"
   target="_blank"
   title="Upload oleh: {{ $file->user->name ?? 'Tidak diketahui' }}">
    {{ $file->file_name }}
</a>


            @if($roleId == 2)
                <button type="button"
                        class="btn btn-xs btn-danger"
                        onclick="deleteFile('{{ $file->id }}')">
                    Hapus
                </button>
            @endif
        </div>
    @endforeach
</td>

@php
    $opsi = [];
    if (!empty($item->opsi_nilai)) {
        $opsi = array_map('trim', explode(',', $item->opsi_nilai));
    }
@endphp

{{-- PENILAIAN MANDIRI — hanya role 2 yang boleh isi --}}
<td>
@if(count($opsi) > 0)
    <select name="penilaian_mandiri[{{ $item->id }}]"
            class="form-control input-sm"
            @if($roleId == 3) disabled @endif>

        <option value="">-- Pilih --</option>

        @foreach($opsi as $nilai)
            <option value="{{ $nilai }}"
                {{ old('penilaian_mandiri.' . $item->id,
                       $item->unit_penilaian->penilaian_mandiri) == $nilai ? 'selected' : '' }}>
                {{ $nilai }}
            </option>
        @endforeach
    </select>
@else
    <input type="number"
           name="penilaian_mandiri[{{ $item->id }}]"
           min="0" max="1" step="0.01"
           value="{{ old('penilaian_mandiri.' . $item->id,
                         $item->unit_penilaian->penilaian_mandiri) }}"
           class="form-control input-sm"
           placeholder="0 - 1"
           @if($roleId == 3) disabled @endif>
@endif
</td>


{{-- TAHAP 1 — hanya non-role-2 boleh isi --}}
@if($showTahap1)
    <td>
        @if(count($opsi) > 0)
            <select name="penilaian_tahap_1[{{ $item->id }}]"
                    class="form-control input-sm"
                    @if($roleId == 2) disabled @endif>

                <option value="">-- Pilih --</option>

                @foreach($opsi as $nilai)
                    <option value="{{ $nilai }}"
                        {{ old('penilaian_tahap_1.' . $item->id,
                               $item->unit_penilaian->penilaian_tahap_1) == $nilai ? 'selected' : '' }}>
                        {{ $nilai }}
                    </option>
                @endforeach
            </select>
        @else
            <input type="number"
                   name="penilaian_tahap_1[{{ $item->id }}]"
                   min="0" max="1" step="0.01"
                   value="{{ old('penilaian_tahap_1.' . $item->id,
                                 $item->unit_penilaian->penilaian_tahap_1) }}"
                   class="form-control input-sm"
                   placeholder="0 - 1"
                   @if($roleId == 2) disabled @endif>
        @endif
    </td>

    <td>
        <textarea name="note_penilaian_1[{{ $item->id }}]"
                  class="form-control input-sm"
                  rows="2"
                  placeholder="Catatan Penilaian 1"
                  @if($roleId == 2) disabled @endif>{{ old('note_penilaian_1.' . $item->id, $item->unit_penilaian->note_penilaian_1) }}</textarea>
    </td>
@endif

{{-- FILE BUKTI 2 — muncul jika penilaian_tahap_1 sudah diisi, hanya role 2 boleh upload & hapus--}}
@if($showFileBukti2)
    <td>
<input type="file"
       name="file_bukti_2[{{ $item->id }}][]"
       accept="application/pdf"
       multiple
       class="form-control input-sm"
       @if($roleId != 2 && $roleId != 1) disabled @endif>

<small class="text-muted">
    * Format wajib PDF, maksimal 25MB per file
</small>

        @foreach($item->bukti->where('metode_index', 2) as $file)
            <div style="margin-top:4px; font-size:11px;">
                📄
<a href="{{ asset('storage/' . $file->file_path) }}"
   target="_blank"
   title="Upload oleh: {{ $file->user->name ?? 'Tidak diketahui' }}">
    {{ $file->file_name }}
</a>


                @if($roleId == 2)
                    <button type="button"
                            class="btn btn-xs btn-danger"
                            onclick="deleteFile('{{ $file->id }}')">
                        Hapus
                    </button>
                @endif
            </div>
        @endforeach
    </td>
@endif


{{-- TAHAP 2 — hanya non-role-2 boleh isi, muncul jika sudah ada nilai tahap 2 --}}
@if($showTahap2)
    <td>
        @if(count($opsi) > 0)
            <select name="penilaian_tahap_2[{{ $item->id }}]"
                    class="form-control input-sm"
                    @if($roleId == 2) disabled @endif>

                <option value="">-- Pilih --</option>

                @foreach($opsi as $nilai)
                    <option value="{{ $nilai }}"
                        {{ old('penilaian_tahap_2.' . $item->id,
                               $item->unit_penilaian->penilaian_tahap_2) == $nilai ? 'selected' : '' }}>
                        {{ $nilai }}
                    </option>
                @endforeach
            </select>
        @else
            <input type="number"
                   name="penilaian_tahap_2[{{ $item->id }}]"
                   min="0" max="1" step="0.01"
                   value="{{ old('penilaian_tahap_2.' . $item->id,
                                 $item->unit_penilaian->penilaian_tahap_2) }}"
                   class="form-control input-sm"
                   placeholder="0 - 1"
                   @if($roleId == 2) disabled @endif>
        @endif
    </td>


    <td>
        <textarea name="note_penilaian_2[{{ $item->id }}]"
                  class="form-control input-sm"
                  rows="2"
                  placeholder="Catatan Penilaian 2"
                  @if($roleId == 2) disabled @endif>{{ old('note_penilaian_2.' . $item->id, $item->unit_penilaian->note_penilaian_2) }}</textarea>
    </td>
@endif


@if($roleId == 1)
<td>
<input type="text"
       name="opsi_nilai[{{ $item->id }}]"
       value="{{ $item->opsi_nilai ?? '' }}"
       class="form-control input-sm"
       style="width:110px;"
       placeholder="3,5,7,9">

</td>
@endif

</tr>

@php $firstItemRow = false; @endphp
@endforeach
@endforeach
@endforeach

{{-- ================= GRAND TOTAL ================= --}}
<tr class="zi-grand-total">
    <td colspan="8" class="text-right">
        <strong>TOTAL KESELURUHAN</strong>
    </td>
    <td>
        <strong>{{ number_format($grandTotal['mandiri'], 2) }}</strong>
    </td>

    @if($showTahap1)
        <td>
            <strong>{{ number_format($grandTotal['tahap1'], 2) }}</strong>
        </td>
        <td></td>
    @endif

    @if($showFileBukti2)
        <td></td>
    @endif

    @if($showTahap2)
        <td>
            <strong>{{ number_format($grandTotal['tahap2'], 2) }}</strong>
        </td>
        <td></td>
    @endif

    @if($roleId == 1)
    <td></td>
@endif

</tr>

</tbody>
</table>

<div class="text-end mt-3">
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>

</form>
</div>

</div>
</div>

{{-- ================= FORM DELETE FILE ================= --}}
<form id="global-delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteFile(id) {
    if (confirm('Hapus file ini?')) {
        let form = document.getElementById('global-delete-form');
        form.action = '/unor/zi/bukti/' + id;
        form.submit();
    }
}
</script>

@endsection