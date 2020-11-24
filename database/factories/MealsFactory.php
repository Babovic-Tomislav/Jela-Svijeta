<?php

namespace Database\Factories;

use App\Models\Meals;

use Illuminate\Database\Eloquent\Factories\Factory;

class MealsFactory extends Factory
{
    protected $model = Meals::class;

    public function definition()
    {
        static $brojac = 1;
        return [

            'created_at'     => $this->faker->datetime(),
            'updated_at'     => $this->faker->datetime(),
            'title:hr'       => 'Naslov jela ' . $brojac . ' na HRV jeziku',
            'title:en'       => 'Title of the dish ' . $brojac
                . ' on ENG language',
            'title:de'       => 'Titel des gerichts ' . $brojac
                . ' in DEN sprache',
            'description:hr' => 'Opis jela ' . $brojac . ' na HRV jeziku',
            'description:en' => 'Dish description ' . $brojac
                . ' on ENG language',
            'description:de' => 'Schüsselbeschreibung ' . $brojac++
                . ' in DEN sprache'
        ];
    }
}
