<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZiBukti extends Model
{
    protected $fillable = [
        'zi_indikator_id',
        'unit_id',
        'metode_index',
        'file_name',
        'file_path',
        'tahun',
    ];
}
