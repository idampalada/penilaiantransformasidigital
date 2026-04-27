<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UptIndikator;
use App\Models\UptBukti;
use App\Models\UptPenilaian;
use Illuminate\Support\Facades\Storage;

class UptBuktiController extends Controller
{
    public function upload(Request $request)
{
$user   = auth()->user();
$roleId = $user->role_id;

// 🔒 CEK: user harus punya unit (kecuali superadmin)
if (!$user->unit_id && $roleId != 1) {
    abort(403, 'User tidak memiliki unit');
}

// 🔒 Tentukan unit dengan aman
if ($roleId == 1) {
    // superadmin boleh pilih unit
    $unitId = $request->input('unit_id');
} else {
    // user biasa: paksa dari session
    $unitId = $user->unit_id;
}

// 🔒 Validasi wajib ada
if (!$unitId) {
    return response()->json([
        'success' => false,
        'message' => 'Unit tidak ditemukan'
    ], 400);
}

// 🔒 Validasi unit exist
$unit = \App\Models\Unit::find($unitId);

if (!$unit) {
    abort(400, 'Unit tidak valid');
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
                        $unitFolder = \App\Models\Unit::find($unitId)->nama ?? 'UNKNOWN';

                        $path = $file->storeAs(
                            "UPT/{$unitFolder}",
                            $filename,
                            'local'
                        );

                        UptBukti::create([
                            'upt_indikator_id' => $indikatorId,
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

    // 🔒 VALIDASI indikator harus ada
    $indikator = UptIndikator::find($indikatorId);

    if (!$indikator) {
        continue; // skip jika tidak valid
    }

    foreach ($rows as $metodeIndex => $value) {

        // 🔒 VALIDASI metode_index harus numeric & wajar
        if (!is_numeric($metodeIndex) || $metodeIndex < 0) {
            continue;
        }

        $data = [];

        if (in_array($roleId, [1, 2])) {
            $data['penilaian_mandiri'] =
                $request->penilaian_mandiri[$indikatorId][$metodeIndex] ?? null;
        }

        if ($user->role->name === 'superadmin' || str_contains($user->role->name,'timpenilai')) {

            $data['penilaian_tahap_1'] =
                $request->penilaian_tahap_1[$indikatorId][$metodeIndex] ?? null;

            $data['note_penilaian_1'] =
                $request->note_penilaian_1[$indikatorId][$metodeIndex] ?? null;

            $data['penilaian_tahap_2'] =
                $request->penilaian_tahap_2[$indikatorId][$metodeIndex] ?? null;

            $data['note_penilaian_2'] =
                $request->note_penilaian_2[$indikatorId][$metodeIndex] ?? null;
        }

        UptPenilaian::updateOrCreate(
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

return response()->json([
    'success' => true,
    'message' => 'Data berhasil disimpan'
]);
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

$query = UptBukti::where('id', $id);

// 🔥 kalau bukan superadmin, baru filter unit
if ($roleId != 1) {
    $query->where('unit_id', optional($user->unit)->id);
}

$bukti = $query->firstOrFail();

        if ($bukti->file_path && Storage::disk('local')->exists($bukti->file_path)) {
            Storage::disk('local')->delete($bukti->file_path);
        }

        $bukti->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
