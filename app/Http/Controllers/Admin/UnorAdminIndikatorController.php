<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnorIndikator;

class UnorAdminIndikatorController extends Controller
{
public function index()
{
    $indikators = UnorIndikator::orderByRaw("
        CASE kategori
            WHEN 'Proses' THEN 1
            WHEN 'Organisasi' THEN 2
            WHEN 'Data' THEN 3
            WHEN 'Teknologi' THEN 4
                WHEN 'Aplikasi' THEN 5
    WHEN 'Keamanan' THEN 6
    ELSE 7
        END
    ")
    ->orderBy('nomor')
    ->get();

    return view('admin.unor.indikator.index', compact('indikators'));
}


    public function create()
    {
        return view('admin.unor.indikator.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nomor' => 'required|integer',
        'kategori' => 'required|in:Organisasi,Proses,Data,Teknologi,Aplikasi,Keamanan',
        'kriteria' => 'required',
        'indikator' => 'required',
        'komponen' => 'required',
        'metode_pengukuran' => 'required',
        'penilaian' => 'required',
        'bukti_persyaratan' => 'required',
    ]);

    UnorIndikator::create($validated);

    return redirect()
    ->route('admin.unor.indikator.index')
    ->with('success', 'Indikator berhasil ditambahkan');
}
public function edit(UnorIndikator $indikator)
{
    return view('admin.unor.indikator.edit', compact('indikator'));
}
public function update(Request $request, UnorIndikator $indikator)
{
    $indikator->update($request->all());

    return redirect()
        ->route('admin.unor.indikator.index')
        ->with('success', 'Indikator berhasil diperbarui');
}
public function destroy($id)
{
    UnorIndikator::findOrFail($id)->delete();

    return redirect()
        ->route('admin.unor.indikator.index')
        ->with('success', 'Indikator berhasil dihapus');
}


}
