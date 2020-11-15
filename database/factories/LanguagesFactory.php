<?php

namespace Database\Factories;

use App\Models\Languages;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Languages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $brojac=0;
        $locale = ['hr','en','de'];
        return [
            'language'=>$locale[$brojac++]
        ];
    }
}
