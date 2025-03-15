<?php

namespace Database\Seeders;

use App\Models\Commentary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Commentary::factory()->count(50)->create();
    }
}
