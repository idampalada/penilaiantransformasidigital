@extends('layouts.zi')

@section('content')
<div class="row">
    <div class="col-md-8">

        <h4><strong>Tambah Unit</strong></h4>
        <p class="text-muted">
            Digunakan untuk UNOR / UNKER / UPT dan role default user-nya
        </p>

        <form method="POST" action="{{ route('admin.units.store') }}">
            @csrf

            {{-- NAMA UNIT --}}
            <div class="form-group mb-3">
                <label>Nama Unit</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       required>
            </div>

            {{-- JENIS UNIT --}}
            <div class="form-group mb-3">
                <label>Jenis Unit</label>
                <select name="jenis" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="UNOR">UNOR</option>
                    <option value="UNKER">UNKER</option>
                    <option value="UPT">UPT</option>
                </select>
            </div>

            {{-- ROLE DEFAULT --}}
            <div class="form-group mb-4">
                <label>Role Default User</label>
                <select name="role_id" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">
                    Role ini otomatis dipakai saat membuat user UNOR
                </small>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>
@endsection
