<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZiIndikator;
use Illuminate\Support\Facades\Storage;

class ZiBuktiController extends Controller
{
    public function upload(Request $request)
{
    $tahun  = 2025;
    $unitId = auth()->user()->unit_id ?? 1;

    // ===== FILE BUKTI 1 =====
    if ($request->hasFile('file_bukti_1')) {
        foreach ($request->file('file_bukti_1') as $indikatorId => $file) {

            $indikator = ZiIndikator::find($indikatorId);
            if (!$indikator) continue;

            if ($indikator->file_bukti_1) {
                Storage::delete($indikator->file_bukti_1);
            }

            $path = $file->storeAs(
                "zi-bukti/{$tahun}/unor-{$unitId}",
                $file->getClientOriginalName()
            );

            $indikator->update([
                'file_bukti_1' => $path
            ]);
        }
    }

    // ===== FILE BUKTI 2 =====
    if ($request->hasFile('file_bukti_2')) {
        foreach ($request->file('file_bukti_2') as $indikatorId => $file) {

            $indikator = ZiIndikator::find($indikatorId);
            if (!$indikator) continue;

            if ($indikator->file_bukti_2) {
                Storage::delete($indikator->file_bukti_2);
            }

            $path = $file->storeAs(
                "zi-bukti/{$tahun}/unor-{$unitId}",
                $file->getClientOriginalName()
            );

            $indikator->update([
                'file_bukti_2' => $path
            ]);
        }
    }

    // ================= PENILAIAN MANDIRI =================
if ($request->has('penilaian_mandiri')) {
    foreach ($request->penilaian_mandiri as $indikatorId => $nilai) {
        ZiIndikator::where('id', $indikatorId)
            ->update(['penilaian_mandiri' => $nilai]);
    }
}

// ================= PENILAIAN TAHAP 1 =================
if ($request->has('penilaian_tahap_1')) {
    foreach ($request->penilaian_tahap_1 as $indikatorId => $nilai) {
        ZiIndikator::where('id', $indikatorId)
            ->update(['penilaian_tahap_1' => $nilai]);
    }
}

// ================= NOTE PENILAIAN 1 =================
if ($request->has('note_penilaian_1')) {
    foreach ($request->note_penilaian_1 as $indikatorId => $note) {
        ZiIndikator::where('id', $indikatorId)
            ->update(['note_penilaian_1' => $note]);
    }
}

// ================= PENILAIAN TAHAP 2 =================
if ($request->has('penilaian_tahap_2')) {
    foreach ($request->penilaian_tahap_2 as $indikatorId => $nilai) {
        ZiIndikator::where('id', $indikatorId)
            ->update(['penilaian_tahap_2' => $nilai]);
    }
}

// ================= NOTE PENILAIAN 2 =================
if ($request->has('note_penilaian_2')) {
    foreach ($request->note_penilaian_2 as $indikatorId => $note) {
        ZiIndikator::where('id', $indikatorId)
            ->update(['note_penilaian_2' => $note]);
    }
}


    return back()->with('success', 'Data berhasil disimpan');
}

}
