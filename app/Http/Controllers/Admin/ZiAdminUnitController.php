<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Role;
use Illuminate\Http\Request;

class ZiAdminUnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('role')->orderBy('id')->get();
        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.units.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string',
            'jenis'   => 'required|in:UNOR,UNKER,UPT',
            'role_id' => 'required|exists:roles,id',
        ]);

        Unit::create([
            'nama'    => $request->nama,
            'jenis'   => $request->jenis,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit berhasil ditambahkan');
    }
}
