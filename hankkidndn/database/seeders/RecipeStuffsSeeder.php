<?php

namespace Database\Seeders;

use App\Models\RecipeStuffs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeStuffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecipeStuffs::factory()->count(500)->create();
    }
}
