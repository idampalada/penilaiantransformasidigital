<?php

namespace App\Http\Controllers;

use App\Models\ZiIndikator;

class ZiIndikatorController extends Controller
{
    public function index()
    {
       $indikators = ZiIndikator::with('bukti') // ← TAMBAHKAN INI
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
    ->map(function ($item) {


            // ================= NORMALISASI =================
            $normOuter = fn ($t) =>
                preg_replace('/\s*\|\|\s*/', '||', trim($t ?? ''));

            $normInner = fn ($t) =>
                preg_replace('/\s*;;\s*/', ';;', trim($t ?? ''));

            // ================= KOMPONEN =================
            $komponens = explode('||', $normOuter($item->komponen));

            $metodeBlocks    = explode('||', $normOuter($item->metode_pengukuran));
            $penilaianBlocks = explode('||', $normOuter($item->penilaian));
            $buktiBlocks     = explode('||', $normOuter($item->bukti_persyaratan));

            $groups = [];
            $totalRows = 0;

            foreach ($komponens as $i => $komponen) {

                // ==== SPLIT PER BARIS (;;) ====
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

                // ==== JUMLAH BARIS MAKS ====
                $rowCount = max(
                    count($metodes),
                    count($penilaians),
                    count($buktis),
                    1
                );

                // ==== NORMALISASI JUMLAH ====
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
