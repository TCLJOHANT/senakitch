<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('recipes')->insert([
            [
                'name' => 'Receta 1',
                'images' => '["image1.jpg", "image2.jpg"]',
                'video' => 'video1.mp4',
                'ingredients' => 'Ingredientes de la receta 1',
                'description' => 'Descripción de la receta 1',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Receta 2',
                'images' => '["image3.jpg", "image4.jpg"]',
                'video' => 'video2.mp4',
                'ingredients' => 'Ingredientes de la receta 2',
                'description' => 'Descripción de la receta 2',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Receta 3',
                'images' => '["image3.jpg", "image4.jpg"]',
                'video' => 'video5.mp4',
                'ingredients' => 'Ingredientes de la receta 3',
                'description' => 'Descripción de la receta 3',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}