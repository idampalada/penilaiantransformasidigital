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
            'kriteria' => 'required|string',
            'indikator' => 'required|string',
            'komponen' => 'required|string',
            'metode' => 'required|array|min:1',
            'penilaian' => 'required|array|min:1',
            'bukti_persyaratan' => 'required|string',
        ]);

        // Gabung metode (||)
        $metodePengukuran = collect($request->metode)
            ->map(fn ($m) => trim($m))
            ->implode('||');

        // Gabung penilaian (;; per baris, || per metode)
        $penilaian = collect($request->penilaian)
            ->map(function ($rows) {
                return collect(explode("\n", $rows))
                    ->map(fn ($r) => trim($r))
                    ->implode(';;');
            })
            ->implode('||');

        ZiIndikator::create([
            'nomor' => $request->nomor,
            'kriteria' => $request->kriteria,
            'indikator' => $request->indikator,
            'komponen' => $request->komponen,
            'metode_pengukuran' => $metodePengukuran,
            'penilaian' => $penilaian,
            'bukti_persyaratan' => $request->bukti_persyaratan,
            'is_active' => true,
        ]);

        return redirect('/admin/indikator')
            ->with('success', 'Indikator berhasil ditambahkan');
    }
}
