<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_path')->unique();
            $table->string('parent_category');
            $table->string('sub_catOne')->nullable()->default('');
            $table->string('sub_catTwo')->nullable()->default('');
            $table->string('sub_catThree')->nullable()->default('');
            $table->string('sub_catFour')->nullable()->default('');
            $table->string('sub_catFive')->nullable()->default('');
            $table->string('sub_catSix')->nullable()->default('');
            $table->integer('ebid_category')->nullable()->default(0);
            $table->integer('bonanza_category')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
