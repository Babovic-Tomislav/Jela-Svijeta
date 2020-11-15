<?php

namespace Database\Factories;

use App\Models\Ingredients;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredients::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $brojac = 1;
        return [
            'title:hr' => 'Naslov sastojka ' . $brojac . ' na HRV jeziku',
            'title:en' => 'Title of ingredient ' . $brojac . ' on ENG language',
            'title:de' => 'Titel des zutat ' . $brojac . ' in DEN sprache',
            'slug' => 'sastojak-' . $brojac++
        ];
    }
}
