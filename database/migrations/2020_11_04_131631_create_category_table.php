<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatecategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'category',
            function (Blueprint $table) {
                $table->id();
                $table->string("slug");
            }
        );

        Schema::create(
            'category_translations',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('category_id');
                $table->string("title");
                $table->string('locale');
                $table->unique(['category_id', 'locale']);
                $table->foreign('category_id')->references('id')->on('category')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('category');
    }
}
