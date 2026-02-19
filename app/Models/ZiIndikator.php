<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZiIndikator extends Model
{
    protected $table = 'zi_indikators';

    protected $fillable = [
        'nomor',
            'kategori',
        'kriteria',
        'indikator',
        'komponen',
        'metode_pengukuran',
        'penilaian',
        'bukti_persyaratan',
                'file_bukti_1',
        'file_bukti_2',
            // penilaian
    'penilaian_mandiri',
    'penilaian_tahap_1',
    'note_penilaian_1',
    'penilaian_tahap_2',
    'note_penilaian_2',
        'is_active',
    ];

    public function bukti()
{
    return $this->hasMany(\App\Models\ZiBukti::class, 'zi_indikator_id');
}

}
