<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UptIndikator;

class UptAdminIndikatorController extends Controller
{
public function index()
{
    $indikators = UptIndikator::orderByRaw("
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

    return view('admin.upt.indikator.index', compact('indikators'));
}


    public function create()
    {
        return view('admin.upt.indikator.create');
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

    UptIndikator::create($validated);

    return redirect()
    ->route('admin.upt.indikator.index')
    ->with('success', 'Indikator berhasil ditambahkan');
}
public function edit(UptIndikator $indikator)
{
    return view('admin.upt.indikator.edit', compact('indikator'));
}
public function update(Request $request, UptIndikator $indikator)
{
    $indikator->update($request->all());

    return redirect()
        ->route('admin.upt.indikator.index')
        ->with('success', 'Indikator berhasil diperbarui');
}
public function destroy($id)
{
    UptIndikator::findOrFail($id)->delete();

    return redirect()
        ->route('admin.upt.indikator.index')
        ->with('success', 'Indikator berhasil dihapus');
}

}
