<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IngredientsMeals extends Migration
{
    public function up()
    {
        Schema::create('ingredients_meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("meals_id");
            $table->foreign('meals_id')
                ->references('id')
                ->on('meals')->onDelete('cascade');

            $table->unsignedBigInteger("ingredients_id");
            $table->foreign('ingredients_id')
                ->references('id')
                ->on('ingredients')->onDelete('cascade');
                $table->dropPrimary();
            $table->primary(['ingredients_id','meals_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients_meals');
    }
}
