<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Validasi & whitelist parameter
        $jenis = strtoupper($request->get('jenis'));

        if (!in_array($jenis, ['UNOR', 'UNKER', 'UPT'])) {
            $jenis = null;
        }

        // ✅ Cache key dinamis berdasarkan filter
        $cacheKey = 'dashboard_' . ($jenis ?? 'all');

        $data = Cache::remember($cacheKey, 60, function () use ($jenis) {

            $query = DB::table('units')

                ->leftJoin('unor_penilaians', 'units.id', '=', 'unor_penilaians.unit_id')
                ->leftJoin('unker_penilaians', 'units.id', '=', 'unker_penilaians.unit_id')
                ->leftJoin('upt_penilaians', 'units.id', '=', 'upt_penilaians.unit_id')

                ->leftJoin('unor_buktis', 'units.id', '=', 'unor_buktis.unit_id')
                ->leftJoin('unker_buktis', 'units.id', '=', 'unker_buktis.unit_id')
                ->leftJoin('upt_buktis', 'units.id', '=', 'upt_buktis.unit_id')

                ->select(
                    'units.jenis',
                    'units.nama',

                    DB::raw("
                        CASE 
                            WHEN units.jenis = 'UNOR' THEN COUNT(DISTINCT unor_penilaians.id)
                            WHEN units.jenis = 'UNKER' THEN COUNT(DISTINCT unker_penilaians.id)
                            WHEN units.jenis = 'UPT' THEN COUNT(DISTINCT upt_penilaians.id)
                            ELSE 0
                        END as total_penilaian
                    "),

                    DB::raw("
                        CASE 
                            WHEN units.jenis = 'UNOR' THEN COUNT(DISTINCT unor_buktis.id)
                            WHEN units.jenis = 'UNKER' THEN COUNT(DISTINCT unker_buktis.id)
                            WHEN units.jenis = 'UPT' THEN COUNT(DISTINCT upt_buktis.id)
                            ELSE 0
                        END as total_bukti
                    ")
                )

                ->when($jenis, function ($q) use ($jenis) {
                    return $q->where('units.jenis', $jenis);
                })

                ->groupBy('units.jenis', 'units.nama')
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