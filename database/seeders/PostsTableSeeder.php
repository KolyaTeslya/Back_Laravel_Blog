<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $imageDirectory = storage_path('app/public/images'); // Путь к директории с изображениями

        $imageFiles = File::allFiles($imageDirectory);
        $imageUrls = [];

        foreach ($imageFiles as $imageFile) {
            $path = $imageFile->getRelativePathname();
            $url = Storage::url("images/{$path}");
            $imageUrls[] = $url;
        }

        // Создание 10 записей с случайными изображениями из директории "images"
        for ($i = 0; $i < 10; $i++) {
            $randomImageUrl = $imageUrls[array_rand($imageUrls)];

            // Извлечь имя файла из URL-адреса
            $imageName = basename($randomImageUrl);

            Post::create([
                'title' => 'Заголовок поста ' . ($i + 1),
                'image' => $imageName,
                'description' => 'Описание поста ' . ($i + 1),
            ]);
        }
    }
}
