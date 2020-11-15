<?php

namespace Database\Factories;

use App\Models\Tags;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagsFactory extends Factory
{
    
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tags::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $brojac = 1;
        return [
            'title:hr' => 'Naslov taga ' . $brojac . ' na HRV jeziku',
            'title:en' => 'Title of tag ' . $brojac . ' on ENG language',
            'title:de'=> 'Titel des tag '.$brojac.' in DEN sprache',
            'slug' => 'tag-'.$brojac++
        ];
    }
}
