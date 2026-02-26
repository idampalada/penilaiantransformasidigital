@extends('layouts.unor')

@section('content')

<h3><strong>REAL TIME PENILAIAN</strong></h3>

<form method="GET" style="margin-bottom:15px;">
    <select name="jenis" onchange="this.form.submit()" class="form-control" style="width:200px;">
<option value="">-- Semua --</option>
<option value="UNOR" {{ ($jenis ?? '') == 'UNOR' ? 'selected' : '' }}>UNOR</option>
<option value="UNKER" {{ ($jenis ?? '') == 'UNKER' ? 'selected' : '' }}>UNKER</option>
<option value="UPT" {{ ($jenis ?? '') == 'UPT' ? 'selected' : '' }}>UPT</option>
    </select>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Jenis Unit</th>
            <th>Nama Unit</th>
            <th>Total Penilaian</th>
            <th>Total Bukti</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->jenis }}</td>
            <td>{{ $row->nama }}</td>
            <td>{{ $row->total_penilaian }}</td>
            <td>{{ $row->total_bukti }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection