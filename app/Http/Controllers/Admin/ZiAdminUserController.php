<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ZiAdminUserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'unit'])
            ->orderBy('id')
            ->get();

        return view('admin.users.index', compact('users'));
    }

public function create()
{
    $roles = Role::orderBy('name')->get();

    // semua unit, tapi akan difilter di frontend
    $units = Unit::orderBy('jenis')
        ->orderBy('nama')
        ->get()
        ->groupBy('jenis'); // UNOR, UNKER, UPT

    return view('admin.users.create', compact('roles', 'units'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id'  => 'required|exists:roles,id',
            'unit_id'  => 'nullable|exists:units,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
            'unit_id'  => $request->unit_id,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dibuat');
    }
}

