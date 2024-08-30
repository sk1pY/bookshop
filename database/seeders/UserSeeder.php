<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = ['admin','user'];
        for ($i = 0; $i < 2; $i++) {
            DB::table('users')->insert([
                'name' => $arr[$i],
                'email' => $arr[$i].'@gmail.com',
                'password' => Hash::make($arr[$i]),
            ]);
        }

    }
}
