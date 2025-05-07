<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasiensSeederTable extends Seeder
{
    public function run()
    {
        $pasiens = [
            [
                'user_id' => 2, // Pastikan user dengan ID ini sudah ada
                'nama' => 'Eddy Syahrul',
                'nik' => '1171041909580002',
                'tanggal_lahir' => '1958-09-19',
                'umur' => 65, // Perbaikan: tanda => diganti dengan =>
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 123',
                'no_hp' => '081234567890',
                'pendidikan_terakhir' => 'S1',
                'pekerjaan' => 'Keuchik',
                'status_kawin' => 'Kawin',
                'golongan_darah' => 'A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Tambahkan data pasien lainnya jika diperlukan
        ];

        // Gunakan insert dengan DB facade untuk multiple records
        //DB::table('pasiens')->insert($pasiens);
        
        // Atau jika menggunakan Eloquent:
         foreach ($pasiens as $pasien) {
            Pasien::create($pasien);
         }
    }
}