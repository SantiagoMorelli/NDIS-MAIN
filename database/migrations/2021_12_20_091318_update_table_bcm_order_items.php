<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableBcmOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bcm_order_items', function (Blueprint $table) {
            $table->text('product_category')->change()->nullable()->after('item_price');
            $table->text('product_category_item')->change()->nullable()->after('product_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bcm_order_items', function (Blueprint $table) {
        });
    }
}

// <?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateSupplierTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('supplier', function (Blueprint $table) {
//             $table->text('supplier_id');
//             $table->string('supplier_name');
//             $table->unsignedBigInteger('order_id');

//             $table->foreign('order_id')->references('order_number')->on('bcm_order');
//             $table->string('product_sku', 30);


//             $table->string('supplier_emailid');

//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('supplier');
//     }
// }