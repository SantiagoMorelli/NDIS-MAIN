<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcmOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   if (!Schema::hasTable('bcm_order_items')) {
        
            Schema::create('bcm_order_items', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('order_id')->unique();
                $table->string('item_name');
                $table->integer('item_quantity');
                $table->decimal('item_price', $precision = 8, $scale = 2);
                $table->string('product_category')->nullable();
                $table->string('product_category_item')->nullable();
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
        if (Schema::hasTable('bcm_order_items')) {
            
            Schema::dropIfExists('bcm_order_items');
        }
        
    }
}
