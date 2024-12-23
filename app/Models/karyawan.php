<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // sesuaikan dengan nama tabel karyawan Anda
    protected $primaryKey = 'nik';
    public $incrementing = false;

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'password',
        // tambahkan field lain yang diperlukan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
