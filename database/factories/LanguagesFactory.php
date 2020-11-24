<?php

namespace Database\Factories;

use App\Models\Languages;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguagesFactory extends Factory
{
    protected $model = Languages::class;

    public function definition()
    {
        static $brojac = 0;
        $locale = ['hr', 'en', 'de'];
        return [
            'language' => $locale[$brojac++]
        ];
    }
}
