<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string("slug");
        });

        Schema::create('tags_translations', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('tags_id');
            $table->string("title");
            $table->string('locale');
            
            $table->unique(['tags_id','locale']);
            $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_translations','tags');
    }
}
