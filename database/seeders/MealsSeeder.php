<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredients;
use App\Models\Meals;
use App\Models\Tags;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagNumber=rand(5,20);
        $ingredientNumber=rand(5,20);
        $categoryNumber=rand(5,20);
        $mealNumber=rand(50,200);

        $ingreadients = Ingredients::factory()->times($ingredientNumber)->create();
        $category = Category::factory()->times($categoryNumber)->create();
        $tags = Tags::factory()->times($tagNumber)->create();
        $meals = Meals::factory()->times($mealNumber)->create()->each(function($meal) use ($ingreadients, $tags, $category)
    {
        $meal->tags()->sync($tags->random(rand(2,5))->pluck('id')->all());
        $meal->Ingredients()->sync($ingreadients->random(rand(3, 7))->pluck('id')->all());
        if(rand(0,1))
        {
            $meal->category()->associate($category->random());
        }
    });

        foreach ($meals as $meal) {
            if($meal->created_at < $meal->updated_at)
            $meal->status = 'modified';
            $meal->save();
        }

        foreach ($meals->random(10) as $meal) {
            $randomDate = Faker::create()->dateTimeBetween($meal->created_at, 'now');
            $meal->deleted_at =$randomDate;
            $meal->updated_at = $randomDate;
            $meal->status = 'deleted';
            $meal->save();
        }


    }
}
