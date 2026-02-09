<?php

namespace App\Http\Controllers;

use App\Models\ZiIndikator;

class ZiIndikatorController extends Controller
{
    /**
     * Landing page UNOR
     */
    public function index()
    {
    $indikators = ZiIndikator::orderByRaw("
        CASE kategori
            WHEN 'Proses' THEN 1
            WHEN 'Organisasi' THEN 2
            WHEN 'Data' THEN 3
            WHEN 'Teknologi' THEN 4
            ELSE 5
        END
    ")
    ->orderBy('nomor')
    ->get();

        return view('zi.index', compact('indikators'));
    }
}
