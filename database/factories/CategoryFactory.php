<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $brojac = 1;
        return [
            'title:hr' => 'Naslov kategorije ' . $brojac . ' na HRV jeziku',
            'title:en' => 'Title of category ' . $brojac . ' on ENG language',
            'title:de' => 'Titel des kategorie ' . $brojac . ' in DEN sprache',
            'slug' => 'category-' . $brojac++
        ];
    }
}
