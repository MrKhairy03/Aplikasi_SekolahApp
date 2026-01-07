<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        $kelasData = [
            ['kode_kelas' => 'X',   'nama_kelas' => 'Kelas X',   'tingkat' => 'X'],
            ['kode_kelas' => 'XI',  'nama_kelas' => 'Kelas XI',  'tingkat' => 'XI'],
            ['kode_kelas' => 'XII', 'nama_kelas' => 'Kelas XII', 'tingkat' => 'XII'],
        ];

        $kelasIds = [];
        foreach ($kelasData as $k) {
            $kelasIds[] = DB::table('kelas')->insertGetId([
                'kode_kelas' => $k['kode_kelas'],
                'nama_kelas' => $k['nama_kelas'],
                'tingkat' => $k['tingkat'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $siswaCounter = 1;
        $guruCounter = 1;
        foreach ($kelasIds as $kelasId) {
            for ($i = 1; $i <= 5; $i++) {
                $userId = DB::table('users')->insertGetId([
                    'name' => 'Siswa ' . $siswaCounter,
                    'email' => 'siswa' . $siswaCounter . '@sekolah.it',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('siswa')->insert([
                    'user_id' => $userId,
                    'kelas_id' => $kelasId,
                    'nis' => 'NIS' . str_pad($siswaCounter, 4, '0', STR_PAD_LEFT),
                    'jenis_kelamin' => $i % 2 === 0 ? 'P' : 'L',
                    'tanggal_lahir' => now()->subYears(rand(15, 18)),
                    'alamat' => 'Alamat Siswa ' . $siswaCounter,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $siswaCounter++;
            }

            for ($i = 1; $i <= 5; $i++) {
                $userId = DB::table('users')->insertGetId([
                    'name' => 'Guru ' . $guruCounter,
                    'email' => 'guru' . $guruCounter . '@sekolah.it',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('guru')->insert([
                    'user_id' => $userId,
                    'kelas_id' => $kelasId,
                    'nip' => 'NIP' . str_pad($guruCounter, 4, '0', STR_PAD_LEFT),
                    'jenis_kelamin' => $i % 2 === 0 ? 'P' : 'L',
                    'no_hp' => '08' . rand(1111111111, 9999999999),
                    'alamat' => 'Alamat Guru ' . $guruCounter,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $guruCounter++;
            }
        }
    }
}
