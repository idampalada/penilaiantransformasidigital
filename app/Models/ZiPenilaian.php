<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZiPenilaian extends Model
{
    protected $table = 'zi_penilaians';

    protected $fillable = [
        'indikator_id',
        'unit_id',
        'file_bukti_1',
        'file_bukti_2',
        'penilaian_mandiri',
        'penilaian_tahap_1',
        'note_penilaian_1',
        'penilaian_tahap_2',
        'note_penilaian_2',
    ];

    public function indikator()
    {
        return $this->belongsTo(ZiIndikator::class, 'indikator_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
