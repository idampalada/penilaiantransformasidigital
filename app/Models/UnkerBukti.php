<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnkerBukti extends Model
{
    protected $fillable = [
        'unker_indikator_id',
        'unit_id',
        'user_id',
        'metode_index',
        'file_name',
        'file_path',
        'tahun',
    ];
    public function indikator()
{
    return $this->belongsTo(\App\Models\UnkerIndikator::class, 'unker_indikator_id');
}
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
