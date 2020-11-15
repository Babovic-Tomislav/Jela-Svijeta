<?php

namespace Database\Seeders;

use App\Models\Languages;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Languages::factory()->times(3)->create();
    }
}
