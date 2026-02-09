<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZiIndikator extends Model
{
    protected $table = 'zi_indikators';

    protected $fillable = [
        'nomor',
        'kriteria',
        'indikator',
        'komponen',
        'metode_pengukuran',
        'penilaian',
        'bukti_persyaratan',
        'is_active',
    ];
}
