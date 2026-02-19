<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZiIndikator;
use App\Models\ZiBukti;
use Illuminate\Support\Facades\Storage;

class ZiBuktiController extends Controller
{
    public function upload(Request $request)
    {
        $user   = auth()->user();
        $role   = $user->role->name ?? null;
        $tahun  = 2025;
        $unitId = $user->unit_id ?? 1;

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

$path = $file->storeAs(
    "UNOR/Bina Marga",
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
        | UPDATE PENILAIAN MANDIRI (SEMUA USER BOLEH)
        |--------------------------------------------------------------------------
        */

        foreach ($request->penilaian_mandiri ?? [] as $id => $nilai) {
            ZiIndikator::where('id', $id)
                ->update(['penilaian_mandiri' => $nilai]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE PENILAIAN TAHAP 1 & 2 (HANYA TIM PENILAI / SUPERADMIN)
        |--------------------------------------------------------------------------
        */

        if (in_array($role, ['superadmin', 'timpenilai'])) {

            foreach ($request->penilaian_tahap_1 ?? [] as $id => $nilai) {
                ZiIndikator::where('id', $id)
                    ->update(['penilaian_tahap_1' => $nilai]);
            }

            foreach ($request->note_penilaian_1 ?? [] as $id => $note) {
                ZiIndikator::where('id', $id)
                    ->update(['note_penilaian_1' => $note]);
            }

            foreach ($request->penilaian_tahap_2 ?? [] as $id => $nilai) {
                ZiIndikator::where('id', $id)
                    ->update(['penilaian_tahap_2' => $nilai]);
            }

            foreach ($request->note_penilaian_2 ?? [] as $id => $note) {
                ZiIndikator::where('id', $id)
                    ->update(['note_penilaian_2' => $note]);
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
        $bukti = ZiBukti::findOrFail($id);

        if ($bukti->file_path && Storage::disk('public')->exists($bukti->file_path)) {
            Storage::disk('public')->delete($bukti->file_path);
        }

        $bukti->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
