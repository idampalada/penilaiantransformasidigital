@extends('layouts.zi')

@section('content')
<h4><strong>Tambah User</strong></h4>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf

    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Role</label>
<select name="role_id" class="form-control" required>
    <option value="">-- Pilih Role --</option>
    @foreach ($roles as $role)
        <option value="{{ $role->id }}">
            {{ $role->name }}
        </option>
    @endforeach
</select>


<div class="form-group mb-3">
    <label>Unit (khusus user UNOR / UNKER / UPT)</label>
<select name="unit_id" class="form-control">
    <option value="">-- Tidak Ada --</option>

    @foreach($units as $jenis => $group)
        <optgroup label="{{ $jenis }}">
            @foreach($group as $unit)
                <option value="{{ $unit->id }}">
                    {{ $unit->nama }}
                </option>
            @endforeach
        </optgroup>
    @endforeach
</select>

</div>


    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
</form>

@endsection
