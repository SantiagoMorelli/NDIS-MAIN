<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBcmOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bcm_order_items', function (Blueprint $table) {
            $table->text('product_category')->change()->default('consumable')->after('item_price');
            $table->text('product_category_item')->change()->default('consumable')->after('product_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('bcm_order_items', function (Blueprint $table) {
            $table->text('product_category')->change()->default('consumable')->after('item_price');
            $table->text('product_category_item')->change()->default('consumable')->after('product_category');
        });
    }
}