<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Akun Admin
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Akun Pasien
        User::create([
            'name'     => 'Eddy Syahrul',
            'nik'      => '1171041909580002', // Pastikan NIK 16 digit
            'password' => Hash::make('1171041909580002'),
            'role'     => 'pasien',
        ]);

        // Akun Petugas
        User::create([
            'name'     => 'Petugas User',
            'email'    => 'petugas@example.com', 
            'password' => Hash::make('petugas123'),
            'role'     => 'petugas',
        ]);

        // Akun Kader
        User::create([
            'name'     => 'Sy. Nadira', 
            'email'    => 'kader@example.com', 
            'password' => Hash::make('kader123'),
            'role'     => 'kader',
        ]);

        $this->call(PasiensSeederTable::class);
        $this->call(KadersSeederTable::class);
        $this->call(PetugasSeederTable::class);

    }
}
