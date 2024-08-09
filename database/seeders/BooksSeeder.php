<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('books')->insert([
                'title' => "book$i",
                'price' => rand(10, 30),
                'author_id'=>rand(1, 10),
                'category_id'=>rand(1, 10),
            ]);
        }
    }
}
