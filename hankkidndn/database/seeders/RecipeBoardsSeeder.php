<?php

namespace Database\Seeders;

use App\Models\RecipeBoards;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeBoardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecipeBoards::factory()->count(200)->create();
    }
}
