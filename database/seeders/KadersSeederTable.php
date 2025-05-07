<?php

namespace Database\Seeders;

use App\Models\Kader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class KadersSeederTable extends Seeder
{
    public function run()
    {
        $kaders = [
            [
                'user_id' => 4, // Pastikan user dengan ID ini sudah ada
                'nama' => 'Sy. Nadira',
                'email' => 'kader@example.com',
                'no_hp' => '088765423456',
                'password' => Hash::make('kader123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
        ];

        // Gunakan insert dengan DB facade untuk multiple records
        //DB::table('kaders')->insert($kaders);
        
        // Atau jika menggunakan Eloquent:
         foreach ($kaders as $kader) {
            Kader::create($kader);
         }
    }
}