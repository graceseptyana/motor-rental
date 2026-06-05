<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        DB::table('motor_types')->insert([
            ['name' => 'Small', 'total_units' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Auto',  'total_units' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Big',   'total_units' => 15, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('users')->insert([
            'name'       => 'Administrator',
            'email'      => 'admin@rental.com',
            'password'   => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}