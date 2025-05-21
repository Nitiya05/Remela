<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = [
            [
                'user_id' => 1, // Pastikan user dengan ID ini sudah ada
                'name'     => 'Petugas User',
                'email'    => 'petugas@example.com', 
                'password' => Hash::make('petugas123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
        ];

        // Gunakan insert dengan DB facade untuk multiple records
        //DB::table('petugas')->insert($petugas);
        
         foreach ($admin as $adminData) {
            Admin::create($adminData);
         }
         }
    }

