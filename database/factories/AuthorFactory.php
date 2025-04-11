<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name =  fake('ru_RU')->firstName();
        $surname = fake('ru_RU')->lastName();
        return [
            'name' => $name,
            'surname' => $surname,
            'slug' => Str::slug($name.'-'.$surname),
        ];
    }
}
