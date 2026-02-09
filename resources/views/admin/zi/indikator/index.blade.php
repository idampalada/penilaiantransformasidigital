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

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kriteria</th>
            <th>Indikator</th>
            <th>Komponen</th>
        </tr>
    </thead>
    <tbody>
        @foreach($indikators as $item)
        <tr>
            <td>{{ $item->nomor }}</td>
            <td>{{ $item->kriteria }}</td>
            <td>{{ $item->indikator }}</td>
            <td>{{ $item->komponen }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
