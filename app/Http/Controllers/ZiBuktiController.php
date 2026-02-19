<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZiIndikator;
use App\Models\ZiBukti;
use App\Models\ZiPenilaian;
use Illuminate\Support\Facades\Storage;

class ZiBuktiController extends Controller
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
| VALIDASI FILE (WAJIB PDF & MAX 25MB)
|--------------------------------------------------------------------------
*/

$request->validate([
    'file_bukti_1.*.*' => 'nullable|file|mimes:pdf|max:25600',
    'file_bukti_2.*.*' => 'nullable|file|mimes:pdf|max:25600',
], [
    'file_bukti_1.*.*.mimes' => 'File Bukti 1 harus format PDF.',
    'file_bukti_1.*.*.max'   => 'Ukuran File Bukti 1 maksimal 25MB.',
    'file_bukti_2.*.*.mimes' => 'File Bukti 2 harus format PDF.',
    'file_bukti_2.*.*.max'   => 'Ukuran File Bukti 2 maksimal 25MB.',
]);


        /*
        |--------------------------------------------------------------------------
        | HANDLE FILE UPLOAD (ROLE 1 & 2 SAJA)
        |--------------------------------------------------------------------------
        */

        if (in_array($roleId, [1, 2])) {

            foreach ($request->allFiles() as $inputName => $indikatorFiles) {

                foreach ($indikatorFiles as $indikatorId => $files) {

                    if (!is_array($files)) {
                        $files = [$files];
                    }

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

                        ZiBukti::create([
                            'zi_indikator_id' => $indikatorId,
                            'unit_id'         => $unitId,
                            'user_id'         => $user->id, // T
                            'metode_index'    => ($inputName === 'file_bukti_1') ? 1 : 2,
                            'file_name'       => $file->getClientOriginalName(),
                            'file_path'       => $path,
                        ]);
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE / CREATE PENILAIAN
        |--------------------------------------------------------------------------
        */

        $allIndikatorIds = collect([
            array_keys($request->penilaian_mandiri ?? []),
            array_keys($request->penilaian_tahap_1 ?? []),
            array_keys($request->penilaian_tahap_2 ?? []),
            array_keys($request->note_penilaian_1 ?? []),
            array_keys($request->note_penilaian_2 ?? []),
        ])->flatten()->unique();

        foreach ($allIndikatorIds as $indikatorId) {

            $data = [];

            /*
            |--------------------------------------------------------------------------
            | PENILAIAN MANDIRI (ROLE 1 & 2)
            |--------------------------------------------------------------------------
            */
            if (in_array($roleId, [1, 2]) &&
                array_key_exists($indikatorId, $request->penilaian_mandiri ?? [])) {

                $value = $request->penilaian_mandiri[$indikatorId];
                $data['penilaian_mandiri'] = $value === '' ? null : $value;
            }

            /*
            |--------------------------------------------------------------------------
            | PENILAIAN TAHAP 1 & 2 (ROLE 1 & 3)
            |--------------------------------------------------------------------------
            */
            if (in_array($roleId, [1, 3])) {

                if (array_key_exists($indikatorId, $request->penilaian_tahap_1 ?? [])) {
                    $value = $request->penilaian_tahap_1[$indikatorId];
                    $data['penilaian_tahap_1'] = $value === '' ? null : $value;
                }

                if (array_key_exists($indikatorId, $request->note_penilaian_1 ?? [])) {
                    $value = $request->note_penilaian_1[$indikatorId];
                    $data['note_penilaian_1'] = $value === '' ? null : $value;
                }

                if (array_key_exists($indikatorId, $request->penilaian_tahap_2 ?? [])) {
                    $value = $request->penilaian_tahap_2[$indikatorId];
                    $data['penilaian_tahap_2'] = $value === '' ? null : $value;
                }

                if (array_key_exists($indikatorId, $request->note_penilaian_2 ?? [])) {
                    $value = $request->note_penilaian_2[$indikatorId];
                    $data['note_penilaian_2'] = $value === '' ? null : $value;
                }
            }

            if (!empty($data)) {
                ZiPenilaian::updateOrCreate(
                    [
                        'indikator_id' => $indikatorId,
                        'unit_id'      => $unitId,
                    ],
                    $data
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE OPSI NILAI (SUPERADMIN ONLY)
        |--------------------------------------------------------------------------
        */

        if ($roleId == 1) {

            foreach ($request->opsi_nilai ?? [] as $id => $opsi) {
                ZiIndikator::where('id', $id)
                    ->update([
                        'opsi_nilai' => $opsi === '' ? null : $opsi
                    ]);
            }
        }

        return back()->with('success', 'Data berhasil disimpan');
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

        $bukti = ZiBukti::where('id', $id)
            ->where('unit_id', optional($user->unit)->id)
            ->firstOrFail();

        if ($bukti->file_path && Storage::disk('public')->exists($bukti->file_path)) {
            Storage::disk('public')->delete($bukti->file_path);
        }

        $bukti->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
