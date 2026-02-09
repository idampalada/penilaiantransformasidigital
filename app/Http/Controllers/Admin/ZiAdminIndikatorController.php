<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZiIndikator;

class ZiAdminIndikatorController extends Controller
{
public function index()
{
    $indikators = ZiIndikator::orderByRaw("
        CASE kategori
            WHEN 'Proses' THEN 1
            WHEN 'Organisasi' THEN 2
            WHEN 'Data' THEN 3
            WHEN 'Teknologi' THEN 4
            ELSE 5
        END
    ")
    ->orderBy('nomor')
    ->get();

    return view('admin.zi.indikator.index', compact('indikators'));
}


    public function create()
    {
        return view('admin.zi.indikator.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nomor' => 'required|integer',
        'kategori' => 'required|in:Organisasi,Proses,Data,Teknologi',
        'kriteria' => 'required',
        'indikator' => 'required',
        'komponen' => 'required',
        'metode_pengukuran' => 'required',
        'penilaian' => 'required',
        'bukti_persyaratan' => 'required',
    ]);

    ZiIndikator::create($validated);

    return redirect('/admin/indikator')
        ->with('success', 'Indikator berhasil ditambahkan');
}
public function edit(ZiIndikator $indikator)
{
    return view('admin.zi.indikator.edit', compact('indikator'));
}
public function update(Request $request, ZiIndikator $indikator)
{
    $indikator->update($request->all());

    return redirect()
        ->route('admin.indikator.index')
        ->with('success', 'Indikator berhasil diperbarui');
}


}
