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
        $indikators = ZiIndikator::query()
            ->where('is_active', true)
            ->orderBy('nomor')
            ->get();

        return view('zi.index', compact('indikators'));
    }
}
