<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->string('status')->default('created');
            $table->timestamps();
            $table->softDeletes();
            
        });

        Schema::create('meals_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meals_id');
            $table->string('locale')->index();
            
            $table->string('title');
            $table->text('description');

            $table->unique(['meals_id', 'locale']);
            $table->foreign('meals_id')->references('id')->on('meals')->onDelete('cascade');
        });

   
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals_translations','meals');
    }
}
