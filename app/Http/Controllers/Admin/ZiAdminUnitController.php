<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class ZiAdminUnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('id')->get();

        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
return view('admin.units.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string',
            'jenis'   => 'required|in:UNOR,UNKER,UPT',
        ]);

Unit::create([
    'nama'  => $request->nama,
    'jenis' => $request->jenis,
]);


        return redirect()->route('admin.units.index')
            ->with('success', 'Unit berhasil ditambahkan');
    }
}
