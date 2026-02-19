<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZiBukti extends Model
{
    protected $fillable = [
        'zi_indikator_id',
        'unit_id',
        'user_id',
        'metode_index',
        'file_name',
        'file_path',
        'tahun',
    ];
    public function indikator()
{
    return $this->belongsTo(\App\Models\ZiIndikator::class, 'zi_indikator_id');
}
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
