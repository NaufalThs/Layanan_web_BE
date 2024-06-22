<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nim', 'username', 'password', 'fakultas', 'program_studi', 'wali_dosen', 'angkatan'
    ];

    protected $hidden = [
        'password',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
