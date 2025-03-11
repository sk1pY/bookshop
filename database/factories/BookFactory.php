<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Storage;

use App\Models\Author;
use App\Models\Category;
use Faker\Provider\ru_RU\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sourcePath = database_path('seeders/booksImages');
        $destinationPath = storage_path('app/public/booksImages');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        $files = File::files($sourcePath);
        foreach ($files as $file) {
            $destination = $destinationPath . '/' . basename($file);
            File::copy($file->getPathname(), $destination);
        }


        return [
            'title' => fake()->sentence(1),
            'description' => fake()->text(1000),
            'price' => fake()->randomFloat(2, 5, 100),
            'image' => $files ? $files[array_rand($files)]->getFilename() : null,
            'author_id' => Author::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id
        ];
    }
}
