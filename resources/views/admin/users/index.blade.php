@extends('layouts.zi')

@section('content')
<h4><strong>Manajemen User</strong></h4>

<a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">
    + Tambah User
</a>

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
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->name ?? '-' }}</td>
            <td>{{ $user->unit->nama ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
