@extends('layouts.zi')

@section('content')

<h4>Master Indikator ZI</h4>

<a href="/admin/indikator/create" class="btn btn-primary mb-3">
    + Tambah Indikator
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table zi-table table-bordered">
    <thead>
        <tr>
            <th style="width:50px">No</th>
            <th style="width:220px">Kriteria</th>
            <th>Indikator</th>
            <th>Komponen</th>
        </tr>
    </thead>
    <tbody>

@php
    $currentKategori = null;
@endphp

@foreach ($indikators as $item)

    {{-- HEADER KATEGORI --}}
    @if ($item->kategori !== $currentKategori)
        <tr class="zi-group-header">
            <td colspan="4">{{ strtoupper($item->kategori) }}</td>
        </tr>
        @php $currentKategori = $item->kategori; @endphp
    @endif

<tr class="zi-group-content">
    <td class="text-center">{{ $item->nomor }}</td>
    <td>{{ $item->kriteria }}</td>
    <td>{{ $item->indikator }}</td>
    <td>{{ $item->komponen }}</td>
    <td>
        <a href="{{ route('admin.indikator.edit', $item->id) }}"
           class="btn btn-sm btn-warning">
            Edit
        </a>
    </td>
</tr>

@endforeach

</tbody>

</table>

@endsection
