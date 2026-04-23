<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $jenis = strtoupper($request->get('jenis'));

        if (!in_array($jenis, ['UNOR', 'UNKER', 'UPT'])) {
            $jenis = null;
        }

        $cacheKey = 'dashboard_' . ($jenis ?? 'all');

        $data = Cache::remember($cacheKey, 5, function () use ($jenis) {

            $query = DB::table('units')

                // PENILAIAN (tetap)
                ->leftJoin('unor_penilaians', 'units.id', '=', 'unor_penilaians.unit_id')
                ->leftJoin('unker_penilaians', 'units.id', '=', 'unker_penilaians.unit_id')
                ->leftJoin('upt_penilaians', 'units.id', '=', 'upt_penilaians.unit_id')

                ->select(
                    'units.id',
                    'units.jenis',
                    'units.nama',

                    // =========================
                    // TOTAL PENILAIAN
                    // =========================
                    DB::raw("
                        CASE 
                            WHEN units.jenis = 'UNOR' THEN COUNT(DISTINCT unor_penilaians.id)
                            WHEN units.jenis = 'UNKER' THEN COUNT(DISTINCT unker_penilaians.id)
                            WHEN units.jenis = 'UPT' THEN COUNT(DISTINCT upt_penilaians.id)
                            ELSE 0
                        END as total_penilaian
                    "),

                    // =========================
                    // TOTAL BUKTI (LOGIKA BARU)
                    // =========================
DB::raw("
    CASE 
        WHEN units.jenis = 'UNOR' THEN (
            SELECT COUNT(DISTINCT (b.unor_indikator_id, b.metode_index))
            FROM unor_buktis b
            WHERE b.unit_id = units.id
        )
        WHEN units.jenis = 'UNKER' THEN (
            SELECT COUNT(DISTINCT (b.unker_indikator_id, b.metode_index))
            FROM unker_buktis b
            WHERE b.unit_id = units.id
        )
        WHEN units.jenis = 'UPT' THEN (
            SELECT COUNT(DISTINCT (b.upt_indikator_id, b.metode_index))
            FROM upt_buktis b
            WHERE b.unit_id = units.id
        )
        ELSE 0
    END as total_bukti
")
                )

                ->when($jenis, function ($q) use ($jenis) {
                    return $q->where('units.jenis', $jenis);
                })

                // 🔥 WAJIB (fix error grouping PostgreSQL)
                ->groupBy('units.id', 'units.jenis', 'units.nama')

                ->orderBy('units.jenis')
                ->orderBy('units.nama');

            return $query->get();
        });

        return view('dashboard', [
            'data' => $data,
            'jenis' => $jenis
        ]);
    }
}   