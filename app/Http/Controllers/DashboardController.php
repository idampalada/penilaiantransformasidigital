<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $jenis = $request->get('jenis');

    $data = DB::table('units')

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

        ->when($jenis, function ($query) use ($jenis) {
            return $query->where('units.jenis', $jenis);
        })

        ->groupBy('units.jenis', 'units.nama')
        ->orderBy('units.jenis')
        ->orderBy('units.nama')
        ->get();

    return view('dashboard', compact('data', 'jenis'));
}
}