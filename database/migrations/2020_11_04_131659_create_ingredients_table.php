<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();

            $table->string("slug");
        });

        Schema::create('ingredients_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredients_id');
            $table->string("title");
            $table->string('locale');

            $table->unique(['ingredients_id', 'locale']);
            $table->foreign('ingredients_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients_translations','ingredients');
        
    }
}
