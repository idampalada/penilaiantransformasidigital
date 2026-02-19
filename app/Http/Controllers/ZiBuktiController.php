<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZiIndikator;
use App\Models\ZiBukti;
use Illuminate\Support\Facades\Storage;
use App\Models\ZiPenilaian;


class ZiBuktiController extends Controller
{
    public function upload(Request $request)
{
    $user   = auth()->user();
    $role   = $user->role->name ?? null;
    $tahun  = 2025;
    $unitId = $user->unit_id;

    /*
    |--------------------------------------------------------------------------
    | HANDLE FILE UPLOAD
    |--------------------------------------------------------------------------
    */

    $allFiles = $request->allFiles();

    if (!empty($allFiles)) {

        foreach ($allFiles as $inputName => $indikatorFiles) {

            foreach ($indikatorFiles as $indikatorId => $files) {

                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {

                    if (!$file || !$file->isValid()) {
                        continue;
                    }

                    $filename = time().'_'.$file->getClientOriginalName();

                    // Folder berdasarkan nama unit
                    $unitFolder = $user->unit->nama;

                    $path = $file->storeAs(
                        "UNOR/{$unitFolder}",
                        $filename,
                        'public'
                    );

                    ZiBukti::create([
                        'zi_indikator_id' => $indikatorId,
                        'unit_id'         => $unitId,
                        'metode_index'    => ($inputName === 'file_bukti_1') ? 1 : 2,
                        'file_name'       => $file->getClientOriginalName(),
                        'file_path'       => $path,
                        'tahun'           => $tahun,
                    ]);
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE / CREATE PENILAIAN (SEMUA USER)
    |--------------------------------------------------------------------------
    */

    foreach ($request->penilaian_mandiri ?? [] as $indikatorId => $nilai) {

        ZiPenilaian::updateOrCreate(
            [
                'indikator_id' => $indikatorId,
                'unit_id'      => $unitId,
            ],
            [
                'penilaian_mandiri' => $nilai,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TAHAP 1 & 2 (HANYA TIM PENILAI / SUPERADMIN)
    |--------------------------------------------------------------------------
    */

    if (in_array($role, ['superadmin', 'timpenilai'])) {

        foreach ($request->penilaian_tahap_1 ?? [] as $indikatorId => $nilai) {

            ZiPenilaian::updateOrCreate(
                [
                    'indikator_id' => $indikatorId,
                    'unit_id'      => $unitId,
                ],
                [
                    'penilaian_tahap_1' => $nilai,
                ]
            );
        }

        foreach ($request->note_penilaian_1 ?? [] as $indikatorId => $note) {

            ZiPenilaian::updateOrCreate(
                [
                    'indikator_id' => $indikatorId,
                    'unit_id'      => $unitId,
                ],
                [
                    'note_penilaian_1' => $note,
                ]
            );
        }

        foreach ($request->penilaian_tahap_2 ?? [] as $indikatorId => $nilai) {

            ZiPenilaian::updateOrCreate(
                [
                    'indikator_id' => $indikatorId,
                    'unit_id'      => $unitId,
                ],
                [
                    'penilaian_tahap_2' => $nilai,
                ]
            );
        }

        foreach ($request->note_penilaian_2 ?? [] as $indikatorId => $note) {

            ZiPenilaian::updateOrCreate(
                [
                    'indikator_id' => $indikatorId,
                    'unit_id'      => $unitId,
                ],
                [
                    'note_penilaian_2' => $note,
                ]
            );
        }
    }

    return back()->with('success', 'Data berhasil disimpan');
}

    /*
    |--------------------------------------------------------------------------
    | DELETE FILE
    |--------------------------------------------------------------------------
    */

    public function delete($id)
{
    $user = auth()->user();

    $bukti = ZiBukti::where('id', $id)
                    ->where('unit_id', $user->unit_id)
                    ->firstOrFail();

    if ($bukti->file_path && Storage::disk('public')->exists($bukti->file_path)) {
        Storage::disk('public')->delete($bukti->file_path);
    }

    $bukti->delete();

    return back()->with('success', 'File berhasil dihapus');
}

}
