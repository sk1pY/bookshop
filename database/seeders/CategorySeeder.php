<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = ['Бестселлеры', 'Нехудожественная литература', 'Художественная литература', 'Детские книги', 'Ужасы, мистика', 'Бизнес-литература', 'Учебная литература','Поэзия','Изучения иностранных языков'];
//        Category::factory()
//            ->count(5)
//            ->create();
        for ($i = 0; $i < count($arr); $i++) {
            Category::create([
                'name' => $arr[array_rand($arr)],
            ]);
        }

    }
}
