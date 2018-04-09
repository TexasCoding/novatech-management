<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entity_id');
            $table->string('sku')->unique();
            $table->float('cost_free_member', 8, 2);
            $table->float('cost_pro_member', 8, 2);
            $table->string('manufacturer');
            $table->float('map_price', 8, 2);
            $table->string('model_number')->nullable()->default('');
            $table->string('mpn')->default('');
            $table->string('name');
            $table->integer('height')->default(0);
            $table->integer('length')->default(0);
            $table->integer('width')->default(0);
            $table->float('shipping_cost', 8, 2);
            $table->integer('ship_from_location')->default(0);
            $table->string('upc_code')->nullable()->default('');
            $table->float('weight', 8, 2);
            $table->string('warranty')->nullable()->default('');
            $table->integer('qty');
            $table->text('return_policy');
            $table->string('image_url');
            $table->string('additional_images')->nullable()->default('');
            $table->text('condition_description');
            $table->text('description');
            $table->text('package_includes');
            $table->string('category_path');
            $table->string('condition');
            $table->boolean('banned')->nullable()->default(true);
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
        Schema::dropIfExists('products');
    }
}
