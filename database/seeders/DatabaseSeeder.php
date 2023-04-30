<?php

namespace Database\Seeders;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Sesi;
use App\Models\Absensi;
use App\Models\Presensi;
use App\Models\Jadwal;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
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
        $guru = [
            [
                'nip_guru' => '1234567',
                'nama_guru'=> 'Agung Mulia Eko Putra',
                'tempat_lahir_guru' => 'Batam',
                'tanggal_lahir_guru' => Carbon::parse('2000-01-01'), 
                'alamat_guru' => 'Jalan Mencari Cinta Sejati 116, Batam, Kepulauan Riau',
                'jenis_kelamin_guru' => 'Laki-laki',
                'email_guru' => 'agungmulia@tes.com',
                'no_telp_guru' => '08123456789',
                'password_guru' => bcrypt('agungmulia')
            ],
            [
                'nip_guru' => '891011',
                'nama_guru'=> 'Michael Angelo',
                'tempat_lahir_guru' => 'Batam',
                'tanggal_lahir_guru' => Carbon::parse('2000-01-01'), 
                'alamat_guru' => 'Jalan TMNT 123, USA',
                'jenis_kelamin_guru' => 'Laki-laki',
                'email_guru' => 'MichaelAngelo@tes.com',
                'no_telp_guru' => '0832141222',
                'password_guru' => bcrypt('MichaelAngelo')
            ],
        ];

        $kelas = [
            [
                'kode_kelas' => 'XDKV1',
                'tingkat_kelas' => 'X',
                'nomor_kelas' => 1,
                'jurusan_kelas' => 'Desain Komunikasi Visual',
                'nip_guru' => '1234567'
            ],
            [
                'kode_kelas' => 'XMSN2',
                'tingkat_kelas' => 'X',
                'nomor_kelas' => 2,
                'jurusan_kelas' => 'Mesin',
                'nip_guru' => '891011'
            ],
        ];

        $siswa = [
            [
                'nis_siswa' => '2424242',
                'nama_siswa'=> 'Michael Jordan',
                'alamat_siswa' => 'Chicago, Illinois, USA',
                'tempat_lahir_siswa' => 'Chicago',
                'tanggal_lahir_siswa' => Carbon::parse('2000-01-01'), 
                'jenis_kelamin_siswa' => 'Laki-laki',
                'email_siswa' => 'Jumpman24@tes.com',
                'kode_kelas' => 'XDKV1',
                'no_telp_siswa' => '082424242424',
                'password_siswa' => bcrypt('jumpman24'),
                
            ],
            [
                'nis_siswa' => '24101010',
                'nama_siswa'=> 'Kobe Bryant',
                'alamat_siswa' => 'Los Angeles, California, USA',
                'tempat_lahir_siswa' => 'Los Angeles',
                'tanggal_lahir_siswa' => Carbon::parse('2000-01-01'), 
                'jenis_kelamin_siswa' => 'Laki-laki',
                'email_siswa' => 'Mamba24@tes.com',
                'kode_kelas' => 'XDKV1',
                'no_telp_siswa' => '082410101001',
                'password_siswa' => bcrypt('mamba24'),
               
            ],
            [
                'nis_siswa' => '3213211',
                'nama_siswa'=> 'John Cena',
                'alamat_siswa' => 'UcantCme St, Illinois, USA',
                'tempat_lahir_siswa' => 'Illinois',
                'tanggal_lahir_siswa' => Carbon::parse('2000-01-01'), 
                'jenis_kelamin_siswa' => 'Laki-laki',
                'email_siswa' => 'UcantCme@tes.com',
                'kode_kelas' => 'XMSN2',
                'no_telp_siswa' => '08321432122',
                'password_siswa' => bcrypt('UcantCme'),
               
            ],
            [
                'nis_siswa' => '1234123',
                'nama_siswa'=> 'Dwayne Johnson',
                'alamat_siswa' => 'Los Angeles, California, USA',
                'tempat_lahir_siswa' => 'Los Angeles',
                'tanggal_lahir_siswa' => Carbon::parse('2000-01-01'), 
                'jenis_kelamin_siswa' => 'Laki-laki',
                'email_siswa' => 'TheRock@tes.com',
                'kode_kelas' => 'XMSN2',
                'no_telp_siswa' => '08321433233',
                'password_siswa' => bcrypt('TheRock'),
                
            ],
        ];

        $absensi =[
            [
                'nis_siswa' => '1234123',
            ],
            [
                'nis_siswa' => '3213211',
            ],
            [
                'nis_siswa' => '24101010',
            ],
            [
                'nis_siswa' => '2424242',
            ],
        ];

        $presensi =[
            [
                'nis_siswa' => '1234123',
            ],
            [
                'nis_siswa' => '3213211',
            ],
            [
                'nis_siswa' => '24101010',
            ],
            [
                'nis_siswa' => '2424242',
            ],
        ];

        $sesi = [
            [
                'id' => 1,
                'nama_sesi' => 'Sesi 1',
                'jam_mulai_sesi'=> Carbon::parse('07:30:00'),
                'jam_selesai_sesi' => Carbon::parse('10:00:00'),
            ],
            [
                'id' => 2,
                'nama_sesi' => 'Sesi 2',
                'jam_mulai_sesi'=> Carbon::parse('10:15:00'),
                'jam_selesai_sesi' => Carbon::parse('12:00:00'),
            ],
            [
                'id' => 3,
                'nama_sesi' => 'Sesi 3',
                'jam_mulai_sesi'=> Carbon::parse('12:15:00'),
                'jam_selesai_sesi' => Carbon::parse('15:00:00'),
            ],
        ];

        $jadwal = [
            [
                'kode_jadwal' => 'JDW1',
                'mata_pelajaran_jadwal'=> 'Sistem Digital',
                'hari_jadwal' => 'Selasa',
                'kode_kelas' => 'XDKV1',
                'nip_guru' => '1234567',
                'sesi' => 1,
            ]
        ];

        $user = [
            [
                'email' => 'agungmulia@tes.com',
                'password' => bcrypt('agungmulia'),
                'is_admin' => 1,
                'name' => 'Agung Mulia Eko Putra'
            ],
            [
                'email' => 'MichaelAngelo@tes.com',
                'password' => bcrypt('MichaelAngelo'),
                'name' => 'Michael Angelo'
            ],
            [
                'email' => 'Jumpman24@tes.com',
                'password' => bcrypt('Jumpman24'),
                'is_admin' => 3,
                'name' => 'Michael Jordan'
            ],
            [
                'email' => 'TheRock@tes.com',
                'password' => bcrypt('TheRock'),
                'is_admin' => 3,
                'name' => 'Dwayne Johnson'
            ],
            [
                'email' => 'UcantCme@tes.com',
                'password' => bcrypt('UcantCme'),
                'is_admin' => 3,
                'name' => 'John Cena'
            ],
            [
                'email' => 'Mamba24@tes.com',
                'password' => bcrypt('Mamba24'),
                'is_admin' => 3,
                'name' => 'Kobe Bryant'
            ],

        ];

        foreach ($guru as $key => $value) {
            Guru::create($value);
        }
        foreach ($kelas as $key => $value) {
            Kelas::create($value);
        }
        foreach ($siswa as $key => $value) {
            Siswa::create($value);
        }
        foreach ($sesi as $key => $value) {
            Sesi::create($value);
        }
        foreach ($jadwal as $key => $value) {
            Jadwal::create($value);
        }
        foreach ($absensi as $key => $value) {
            Absensi::create($value);
        }
        foreach ($presensi as $key => $value) {
            Presensi::create($value);
        }
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}