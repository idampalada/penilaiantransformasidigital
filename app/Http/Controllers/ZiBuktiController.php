<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZiBukti;
use Illuminate\Support\Facades\Storage;

class ZiBuktiController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'bukti.*.*' => 'required|mimes:pdf|max:10240', // max 10MB
        ]);

        $unitId = auth()->user()->unit_id ?? 1; // sementara UNOR
        $tahun = 2025;

        foreach ($request->file('bukti') as $indikatorId => $files) {
            foreach ($files as $metodeIndex => $file) {

                $path = $file->store(
                    "zi-bukti/{$tahun}/unor-{$unitId}/indikator-{$indikatorId}"
                );

                ZiBukti::updateOrCreate(
                    [
                        'zi_indikator_id' => $indikatorId,
                        'unit_id' => $unitId,
                        'metode_index' => is_numeric($metodeIndex) ? $metodeIndex : null,
                        'tahun' => $tahun,
                    ],
                    [
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]
                );
            }
        }

        return back()->with('success', 'File bukti berhasil diunggah');
    }
}
