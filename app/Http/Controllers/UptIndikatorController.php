<?php

namespace App\Http\Controllers;

use App\Models\UptIndikator;
use App\Models\UptPenilaian;

class UptIndikatorController extends Controller
{
    public function index()
    {
$user = auth()->user();

/*
|--------------------------------------------------------------------------
| Tentukan Unit Berdasarkan Role
|--------------------------------------------------------------------------
*/

$roleName = $user->role->name ?? null;
$jenisUser = $user->unit->jenis ?? null;

if($roleName === 'superadmin'){

    $unitId = request('unit_id');

    // 🔒 FILTER UNIT BERDASARKAN JENIS USER
    $units = \App\Models\Unit::where('jenis', $jenisUser)
        ->orderBy('nama')
        ->get();

    if(!$unitId){

        $indikators = collect();

        return view('upt.index', compact('indikators','units'));
    }

    // 🔒 VALIDASI AGAR TIDAK BISA AKSES JENIS LAIN
    $allowedUnit = \App\Models\Unit::where('id', $unitId)
        ->where('jenis', $jenisUser)
        ->first();

    if(!$allowedUnit){
        abort(403, 'Tidak boleh akses unit ini');
    }
}elseif(str_contains($roleName,'timpenilai')){

    // tim penilai melihat unit yang dipilih
    $unitId = request('unit_id');

}else{

    // user biasa
    $unitId = $user->unit_id;
}

        $indikators = UptIndikator::with([
            'bukti' => function ($q) use ($unitId) {
                $q->where('unit_id', $unitId);
            },
            'penilaians' => function ($q) use ($unitId) {
                $q->where('unit_id', $unitId);
            }
        ])
                ->orderByRaw("
    CASE kategori
        WHEN 'Organisasi' THEN 1
        WHEN 'Proses' THEN 2
        WHEN 'Data' THEN 3
        WHEN 'Teknologi' THEN 4
        WHEN 'Aplikasi' THEN 5
        WHEN 'Keamanan' THEN 6
        ELSE 7
    END
")
        ->orderBy('nomor')
        ->get()
        ->map(function ($item) use ($unitId) {

            /*
            |--------------------------------------------------------------------------
            | Ambil Penilaian Khusus Unit Ini
            |--------------------------------------------------------------------------
            */

            $penilaian = $item->penilaians->first();

            $item->unit_penilaian = $penilaian ?? new UptPenilaian([
                'indikator_id' => $item->id,
                'unit_id'      => $unitId,
            ]);

            /*
            |--------------------------------------------------------------------------
            | LOGIKA GROUPING (TIDAK DIUBAH)
            |--------------------------------------------------------------------------
            */

            $normOuter = fn ($t) =>
                preg_replace('/\s*\|\|\s*/', '||', trim($t ?? ''));

            $normInner = fn ($t) =>
                preg_replace('/\s*;;\s*/', ';;', trim($t ?? ''));

            $komponens = explode('||', $normOuter($item->komponen));
            $metodeBlocks    = explode('||', $normOuter($item->metode_pengukuran));
            $penilaianBlocks = explode('||', $normOuter($item->penilaian));
            $buktiBlocks     = explode('||', $normOuter($item->bukti_persyaratan));

            $groups = [];
            $totalRows = 0;

            foreach ($komponens as $i => $komponen) {

                $metodes = array_values(array_filter(
                    array_map('trim',
                        explode(';;', $normInner($metodeBlocks[$i] ?? ''))
                    )
                ));

                $penilaians = array_values(array_filter(
                    array_map('trim',
                        explode(';;', $normInner($penilaianBlocks[$i] ?? ''))
                    )
                ));

                $buktis = array_values(array_filter(
                    array_map('trim',
                        explode(';;', $normInner($buktiBlocks[$i] ?? ''))
                    )
                ));

                $rowCount = max(
                    count($metodes),
                    count($penilaians),
                    count($buktis),
                    1
                );

                $metodes    = array_pad($metodes,    $rowCount, '');
                $penilaians = array_pad($penilaians, $rowCount, '');
                $buktis     = array_pad($buktis,     $rowCount, '');

                $groups[] = [
                    'komponen'   => trim($komponen),
                    'rows'       => collect(range(0, $rowCount - 1))->map(function ($idx) use ($metodes, $penilaians, $buktis) {
                        return [
                            'metode'    => $metodes[$idx],
                            'penilaian' => $penilaians[$idx],
                            'bukti'     => $buktis[$idx],
                        ];
                    }),
                    'rowspan'    => $rowCount,
                ];

                $totalRows += $rowCount;
            }

            $item->groups = $groups;
            $item->total_rows = $totalRows;

            return $item;
        });
if($roleName === 'superadmin'){
    // sudah di-handle di atas, jangan override lagi
}else{
    if($user->unit){
        $units = \App\Models\Unit::where('jenis',$user->unit->jenis)
            ->orderBy('nama')
            ->get();
    }else{
        $units = \App\Models\Unit::where('jenis','UPT')
            ->orderBy('nama')
            ->get();
    }
}
return view('upt.index', compact('indikators', 'units'));
    }
}
