<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_category_items')) {
            Schema::create('product_category_items', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('item_number');
                $table->text('item_name')->nullable();
                $table->text('category_name')->nullable();
                $table->integer('priority')->nullable();
                $table->tinyInteger('status')->comment('0 = inactive, 1 = active')->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_category_items');
    }
}
