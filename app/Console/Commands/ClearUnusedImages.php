<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Book;


class ClearUnusedImages extends Command
{
    protected $signature = 'images:clear-unused';
    protected $description = 'Удалить неиспользуемые изображения';

    public function handle()
    {
        $imagesPath = public_path('storage/booksImages');
        $usedImages = Book::pluck('image')->toArray();

        foreach (File::allFiles($imagesPath) as $file) {
            if (!in_array($file->getFilename(), $usedImages)) {
                File::delete($file->getRealPath());
                $this->info('Удалено: ' . $file->getFilename());
            }

            $this->info('Очистка завершена.');
        }
    }
}
