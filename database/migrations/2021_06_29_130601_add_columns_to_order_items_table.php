<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('order_items')) {
            if (!Schema::hasColumn('order_items', 'product_category')) {
                Schema::table('order_items', function($table) {
                    $table->string('product_category',100)->after('item_price')->nullable();
                });
            }
            if (!Schema::hasColumn('order_items', 'product_category_item')) {
                Schema::table('order_items', function($table) {
                    $table->string('product_category_item',100)->after('product_category')->nullable();
                });
            }
            if (!Schema::hasColumn('order_items', 'response')) {
                Schema::table('order_items', function($table) {
                    $table->text('response')->after('product_category_item')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['product_category']);
            $table->dropColumn(['product_category_item']);
            $table->dropColumn(['response']);
        });
    }
}
