<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 50000,
                'name' => 'Martinus Angger',
                'email' => 'AnggerBudi@gmail.com',
                'password' => bcrypt('Angger'),
                'akses' => 'pemilik',
                'foto' => 'angger',
            ],
            [
                'id' => 60000,
                'name' => 'Antonius Yoga',
                'email' => 'AntoniusYoga@gmail.com',
                'password' => bcrypt('Antonius'),
                'akses' => 'pemilik',
                'foto' => 'yoga',
            ]
        ]);
    }
}
