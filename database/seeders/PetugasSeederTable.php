<?php

namespace Database\Seeders;

use App\Models\petugas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PetugasSeederTable extends Seeder
{
    public function run()
    {
        $petugas = [
            [
                'user_id' => 3, // Pastikan user dengan ID ini sudah ada
                'nama'     => 'Petugas User',
                'email'    => 'petugas@example.com', 
                'password' => Hash::make('petugas123'),
                'no_hp' => '088765423456',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
        ];

        // Gunakan insert dengan DB facade untuk multiple records
        //DB::table('petugas')->insert($petugas);
        
        // Atau jika menggunakan Eloquent:
         foreach ($petugas as $petugas) {
            petugas::create($petugas);
         }
    }
}