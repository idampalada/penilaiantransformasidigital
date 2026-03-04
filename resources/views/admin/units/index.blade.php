@extends('layouts.unor')

@section('content')
<h4><strong>Master Unit</strong></h4>

<a href="/admin/units/create" class="btn btn-primary mb-3">
    + Tambah Unit
</a>

<form method="GET" class="mb-3" style="max-width:250px;">
    <select name="jenis" class="form-control" onchange="this.form.submit()">
        <option value="">Semua Jenis</option>
        <option value="UNOR" {{ request('jenis')=='UNOR'?'selected':'' }}>UNOR</option>
        <option value="UNKER" {{ request('jenis')=='UNKER'?'selected':'' }}>UNKER</option>
        <option value="UPT" {{ request('jenis')=='UPT'?'selected':'' }}>UPT</option>
    </select>
</form>

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

        @php
        $color = '#6c757d';

        if($unit->jenis == 'UNOR'){
            $color = '#dc3545'; // merah
        }elseif($unit->jenis == 'UNKER'){
            $color = '#ffc107'; // kuning
        }elseif($unit->jenis == 'UPT'){
            $color = '#198754'; // hijau
        }
        @endphp

        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $unit->nama }}</td>

            <td>
                <span style="
                    background: {{ $color }};
                    color: white;
                    padding:4px 12px;
                    border-radius:20px;
                    font-size:12px;
                    font-weight:600;
                ">
                    {{ $unit->jenis }}
                </span>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>
@endsection