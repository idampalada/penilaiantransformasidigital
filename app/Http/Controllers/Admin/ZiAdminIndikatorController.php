<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZiIndikator;

class ZiAdminIndikatorController extends Controller
{
    public function index()
    {
        $indikators = ZiIndikator::orderBy('nomor')->get();
        return view('admin.zi.indikator.index', compact('indikators'));
    }

    public function create()
    {
        return view('admin.zi.indikator.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|integer',
            'kriteria' => 'required',
            'indikator' => 'required',
            'komponen' => 'required',
            'metode_pengukuran' => 'required',
            'penilaian' => 'required',
            'bukti_persyaratan' => 'required',
        ]);

        ZiIndikator::create([
            'nomor' => $request->nomor,
            'kriteria' => $request->kriteria,
            'indikator' => $request->indikator,
            'komponen' => $request->komponen,
            'metode_pengukuran' => $request->metode_pengukuran,
            'penilaian' => $request->penilaian,
            'bukti_persyaratan' => $request->bukti_persyaratan,
        ]);

        return redirect('/admin/indikator')
            ->with('success', 'Indikator berhasil ditambahkan');
    }
}
