<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'role_id',
    ];

    // 🔗 RELASI KE ROLE
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // 🔗 RELASI KE USER (opsional tapi rapi)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
