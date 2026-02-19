<?php

namespace App\Http\Controllers;

use App\Models\ZiIndikator;
use App\Models\ZiPenilaian;

class ZiIndikatorController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $unitId = $user->unit_id;

        $indikators = ZiIndikator::with([
            'bukti' => function ($q) use ($unitId) {
                $q->where('unit_id', $unitId);
            },
            'penilaians' => function ($q) use ($unitId) {
                $q->where('unit_id', $unitId);
            }
        ])
        ->orderByRaw("
            CASE kategori
                WHEN 'Proses' THEN 1
                WHEN 'Organisasi' THEN 2
                WHEN 'Data' THEN 3
                WHEN 'Teknologi' THEN 4
                ELSE 5
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

            $item->unit_penilaian = $penilaian ?? new ZiPenilaian([
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

        return view('zi.index', compact('indikators'));
    }
}
