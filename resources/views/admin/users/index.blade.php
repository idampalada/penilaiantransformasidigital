@extends('layouts.unor')

@section('content')
<h4><strong>Manajemen User</strong></h4>

<a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">
    + Tambah User
</a>

<form method="GET" class="mb-3" style="max-width:250px;">
    <select name="role" class="form-control" onchange="this.form.submit()">
        <option value="">Semua Role</option>
        <option value="superadmin" {{ request('role')=='superadmin'?'selected':'' }}>Super Admin</option>
        <option value="timpenilai" {{ request('role')=='timpenilai'?'selected':'' }}>Tim Penilai</option>
        <option value="user" {{ request('role')=='user'?'selected':'' }}>User</option>
    </select>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)

@php
$color = '#6c757d';

if($user->role->name == 'superadmin'){
    $color = '#dc3545'; // merah
}elseif($user->role->name == 'timpenilai'){
    $color = '#0d6efd'; // biru
}elseif($user->role->name == 'user'){
    $color = '#198754'; // hijau
}
@endphp


        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>

            <td>
<span style="
background: {{ $color }};
color: white;
padding:4px 10px;
border-radius:20px;
font-size:12px;
font-weight:600;
">
{{ $user->role->name ?? '-' }}
</span>
            </td>

            <td>{{ $user->unit->nama ?? '-' }}</td>
        </tr>

    @endforeach
    </tbody>
</table>
@endsection