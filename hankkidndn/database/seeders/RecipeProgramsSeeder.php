<?php

namespace Database\Seeders;

use App\Models\RecipePrograms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecipePrograms::factory()->count(500)->create();
    }
}
