<?php

namespace Database\Seeders;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $guru = [
        //     [
        //         'nip_guru' => '1234567',
        //         'nama_guru'=> 'Agung Mulia Eko Putra',
        //         'alamat_guru' => 'Jalan Mencari Cinta Sejati 116, Batam, Kepulauan Riau',
        //         'jenis_kelamin_guru' => 'Laki-laki',
        //         'email_guru' => 'agungmulia@tes.com',
        //         'no_telp_guru' => '08123456789',
        //         'password_guru' => bcrypt('agungmulia')
        //     ]
        // ];

        $kelas = [
            [
                'kode_kelas' => 'XMLD1',
                'tingkat_kelas' => 'X',
                'nomor_kelas' => 1,
                'jurusan_kelas' => 'multimedia',
                'wali_kelas' => '1234567'
            ] 
        ];

        $siswa = [
            [
                'nis_siswa' => '2424242',
                'nama_siswa'=> 'Michael Jordan',
                'alamat_siswa' => 'Chicago, Illinois, USA',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'email_siswa' => 'Jumpman24@tes.com',
                'kode_kelas' => 'XMLD1',
                'no_telp_siswa' => '082424242424',
                'password_siswa' => bcrypt('jumpman24'),
                'hadir_siswa' => 1,
                'izin_siswa' => 0,
                'alpha_siswa' => 0
            ],
            [
                'nis_siswa' => '24101010',
                'nama_siswa'=> 'Kobe Bryant',
                'alamat_siswa' => 'Los Angeles, California, USA',
                'jenis_kelamin_siswa' => 'Laki-laki',
                'email_siswa' => 'jMamba24@tes.com',
                'kode_kelas' => 'XMLD1',
                'no_telp_siswa' => '082410101001',
                'password_siswa' => bcrypt('mamba24'),
                'hadir_siswa' => 1,
                'izin_siswa' => 0,
                'alpha_siswa' => 0
            ],
        ];

        // foreach ($guru as $key => $value) {
        //     Guru::create($value);
        // }
        foreach ($kelas as $key => $value) {
            Kelas::create($value);
        }
        foreach ($siswa as $key => $value) {
            Siswa::create($value);
        }
    }
}