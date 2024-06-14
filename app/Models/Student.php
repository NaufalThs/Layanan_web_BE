<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nim', 'username', 'password', 'fakultas', 'program_studi', 'wali_dosen', 'angkatan'
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
