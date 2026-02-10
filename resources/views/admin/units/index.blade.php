@extends('layouts.zi')

@section('content')
<h4><strong>Master Unit</strong></h4>

<a href="/admin/units/create" class="btn btn-primary mb-3">
    + Tambah Unit
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Unit</th>
            <th>Jenis</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($units as $i => $unit)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $unit->nama }}</td>
            <td>{{ $unit->jenis }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
