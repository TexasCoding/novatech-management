<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbidCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebid_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_path')->unique();
            $table->integer('category_id')->unique();
            $table->string('parent_category');
            $table->string('sub_catOne')->nullable()->default('');
            $table->string('sub_catTwo')->nullable()->default('');
            $table->string('sub_catThree')->nullable()->default('');
            $table->string('sub_catFour')->nullable()->default('');
            $table->string('sub_catFive')->nullable()->default('');
            $table->string('sub_catSix')->nullable()->default('');
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
        Schema::dropIfExists('ebid_categories');
    }
}
