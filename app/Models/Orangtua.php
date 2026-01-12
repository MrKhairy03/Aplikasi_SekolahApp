<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kelas;

class Orangtua extends Model
{
    protected $table = 'orang_tua';

    protected $fillable = [
        'user_id',
        'siswa_id',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
