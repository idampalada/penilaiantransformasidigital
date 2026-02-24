<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnorBukti extends Model
{
    protected $fillable = [
        'unor_indikator_id',
        'unit_id',
        'user_id',
        'metode_index',
        'file_name',
        'file_path',
        'tahun',
    ];
    public function indikator()
{
    return $this->belongsTo(\App\Models\UnorIndikator::class, 'unor_indikator_id');
}
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
