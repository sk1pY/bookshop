<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;


class InterfaceSiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sourcePath = database_path('seeders/slideImages');
        $destinationPath = storage_path('app/public/slideImages');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        $files = File::files($sourcePath);
        foreach ($files as $file) {
            $destination = $destinationPath . '/' . basename($file);
            File::copy($file->getPathname(), $destination);
        }
        return [
            'image' => $files[array_rand($files)]->getFilename(),
            'type' =>  'slide'
        ];
    }
}
