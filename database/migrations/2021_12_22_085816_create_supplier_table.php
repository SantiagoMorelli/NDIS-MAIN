<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->text('supplier_id');
            $table->string('supplier_name');
            $table->unsignedBigInteger('order_id');

            $table->foreign('order_id')->references('order_number')->on('bcm_order');
            $table->string('product_sku', 30);


            $table->string('supplier_emailid');

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
        Schema::dropIfExists('supplier');
    }
}