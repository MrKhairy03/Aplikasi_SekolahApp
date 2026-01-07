<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kelas;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nip',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
