<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user superadmin
        $user = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('ge49in108za135'), // Hash password
        ]);

        // Buat data employee untuk superadmin
        Employee::create([
            'user_id' => $user->id,
            'name' => 'superadmin',
            'department' => 'IT',
            'position' => 'Kepala IT',
            'manager' => 'superadmin',
            'employee_type' => 'Pegawai Tetap',
            'email' => 'superadmin@gmail.com',
            'phone_number' => '081805003532',
            'ktp_address' => 'Jl Pakis Gunung 3A nomor 24, Surabaya',
            'ktp_city' => 'Kota Surabaya',
            'domicile_address' => 'Jl Pakis Gunung 3A nomor 24, Surabaya',
            'domicile_city' => 'Kota Surabaya',
            'bank_account' => '56780931242',
            'net_salary' => 0,
            'nationality' => 'WNI',
            'ktp_number' => '3550605040021',
            'gender' => 'Laki-Laki',
            'date_of_birth' => '2004-05-06', // Format YYYY-MM-DD
            'place_of_birth' => 'Surabaya',
            'marital_status' => 'Belum Nikah',
            'spouse_complete_name' => '-',
            'number_of_dependent_children' => 0,
            'educational_level' => 'Sarjana',
            'field_of_study' => 'Informatika',
            'school' => 'UPN Veteran Jawa Timur',
        ]);
    }
}
