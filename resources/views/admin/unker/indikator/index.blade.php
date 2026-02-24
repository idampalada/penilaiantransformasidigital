@extends('layouts.unker')

@section('content')

<h4>Master Indikator UNKER</h4>

<a href="/admin/unker/indikator/create" class="btn btn-primary mb-3">
    + Tambah Indikator
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table unker-table table-bordered">
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
        <tr class="unker-group-header">
            <td colspan="4">{{ strtoupper($item->kategori) }}</td>
        </tr>
        @php $currentKategori = $item->kategori; @endphp
    @endif

<tr class="unor-group-content">
    <td class="text-center">{{ $item->nomor }}</td>
    <td>{{ $item->kriteria }}</td>
    <td>{{ $item->indikator }}</td>
    <td>{{ $item->komponen }}</td>
    <td class="text-center">
        <a href="{{ route('admin.indikator.edit', $item->id) }}"
           class="btn btn-sm btn-warning">
            Edit
        </a>

        <form action="{{ route('admin.indikator.destroy', $item->id) }}"
              method="POST"
              style="display:inline-block"
              onsubmit="return confirm('Yakin mau hapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                Delete
            </button>
        </form>
    </td>
</tr>

@endforeach

</tbody>

</table>

@endsection
