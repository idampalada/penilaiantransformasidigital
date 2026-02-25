<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnorIndikator;
use App\Models\UnorBukti;
use App\Models\UnorPenilaian;
use Illuminate\Support\Facades\Storage;

class UnorBuktiController extends Controller
{
    public function upload(Request $request)
{
    $user   = auth()->user();
    $roleId = $user->role_id;
    $unitId = optional($user->unit)->id;

    if (!$unitId) {
        return back()->withErrors('User belum terhubung dengan unit.');
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI FILE
    |--------------------------------------------------------------------------
    */
    $request->validate([
        'file_bukti_1.*.*.*' => 'nullable|file|mimes:pdf|max:25600',
        'file_bukti_2.*.*.*' => 'nullable|file|mimes:pdf|max:25600',
    ]);

    /*
    |--------------------------------------------------------------------------
    | HANDLE FILE UPLOAD (ROLE 1 & 2)
    |--------------------------------------------------------------------------
    */
    if (in_array($roleId, [1, 2])) {

        foreach (['file_bukti_1', 'file_bukti_2'] as $inputName) {

            $allFiles = $request->file($inputName);

            if (empty($allFiles)) {
                continue;
            }

            foreach ($allFiles as $indikatorId => $metodeFiles) {

                foreach ($metodeFiles as $metodeIndex => $files) {

                    foreach ($files as $file) {

                        if (!$file || !$file->isValid()) {
                            continue;
                        }

                        $filename   = time().'_'.$file->getClientOriginalName();
                        $unitFolder = $user->unit->nama ?? 'UNKNOWN';

                        $path = $file->storeAs(
                            "UNOR/{$unitFolder}",
                            $filename,
                            'public'
                        );

                        UnorBukti::create([
                            'unor_indikator_id' => $indikatorId,
                            'unit_id'           => $unitId,
                            'user_id'           => $user->id,
                            'metode_index'      => $metodeIndex,
                            'metode_type'       => $inputName === 'file_bukti_1' ? 1 : 2,
                            'file_name'         => $file->getClientOriginalName(),
                            'file_path'         => $path,
                        ]);
                    }
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE / CREATE PENILAIAN (PER ROW)
    |--------------------------------------------------------------------------
    */
    $datasets = [
        $request->penilaian_mandiri ?? [],
        $request->penilaian_tahap_1 ?? [],
        $request->penilaian_tahap_2 ?? [],
        $request->note_penilaian_1 ?? [],
        $request->note_penilaian_2 ?? [],
    ];

    foreach ($datasets as $dataset) {

        foreach ($dataset as $indikatorId => $rows) {

            foreach ($rows as $metodeIndex => $value) {

                $data = [];

                if (in_array($roleId, [1, 2])) {
                    $data['penilaian_mandiri'] =
                        $request->penilaian_mandiri[$indikatorId][$metodeIndex] ?? null;
                }

                if (in_array($roleId, [1, 3])) {

                    $data['penilaian_tahap_1'] =
                        $request->penilaian_tahap_1[$indikatorId][$metodeIndex] ?? null;

                    $data['note_penilaian_1'] =
                        $request->note_penilaian_1[$indikatorId][$metodeIndex] ?? null;

                    $data['penilaian_tahap_2'] =
                        $request->penilaian_tahap_2[$indikatorId][$metodeIndex] ?? null;

                    $data['note_penilaian_2'] =
                        $request->note_penilaian_2[$indikatorId][$metodeIndex] ?? null;
                }

                UnorPenilaian::updateOrCreate(
                    [
                        'indikator_id' => $indikatorId,
                        'unit_id'      => $unitId,
                        'metode_index' => $metodeIndex,
                    ],
                    $data
                );
            }
        }
    }

    return redirect()->route('unor.index')
        ->with('success', 'Data berhasil disimpan.');
}
    /*
    |--------------------------------------------------------------------------
    | DELETE FILE (ROLE 1 & 2 SAJA)
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $user   = auth()->user();
        $roleId = $user->role_id;

        if (!in_array($roleId, [1, 2])) {
            abort(403, 'Tidak diizinkan menghapus file.');
        }

        $bukti = UnorBukti::where('id', $id)
            ->where('unit_id', optional($user->unit)->id)
            ->firstOrFail();

        if ($bukti->file_path && Storage::disk('public')->exists($bukti->file_path)) {
            Storage::disk('public')->delete($bukti->file_path);
        }

        $bukti->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
