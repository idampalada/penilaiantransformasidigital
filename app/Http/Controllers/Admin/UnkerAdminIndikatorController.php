<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnkerIndikator;

class UnkerAdminIndikatorController extends Controller
{
public function index()
{
    $indikators = UnkerIndikator::orderByRaw("
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

    return view('admin.unker.indikator.index', compact('indikators'));
}


    public function create()
    {
        return view('admin.unker.indikator.create');
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

    UnkerIndikator::create($validated);

    return redirect()
    ->route('admin.unker.indikator.index')
    ->with('success', 'Indikator berhasil ditambahkan');
}
public function edit(UnkerIndikator $indikator)
{
    return view('admin.unker.indikator.edit', compact('indikator'));
}
public function update(Request $request, UnkerIndikator $indikator)
{
    $indikator->update($request->all());

    return redirect()
        ->route('admin.unker.indikator.index')
        ->with('success', 'Indikator berhasil diperbarui');
}
public function destroy($id)
{
    UnkerIndikator::findOrFail($id)->delete();

    return redirect()
        ->route('admin.unker.indikator.index')
        ->with('success', 'Indikator berhasil dihapus');
}

}
