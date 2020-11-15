<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MealsTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("meals_id");
            $table->foreign('meals_id')
                ->references('id')
                ->on('meals')->onDelete('cascade');

            $table->unsignedBigInteger("tags_id");
            $table->foreign('tags_id')
                ->references('id')
                ->on('tags')->onDelete('cascade');
            $table->dropPrimary();
            $table->primary(['meals_id','tags_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals_tags');
    }
}
