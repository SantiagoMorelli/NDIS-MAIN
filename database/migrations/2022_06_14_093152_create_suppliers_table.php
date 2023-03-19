<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('supplier')) {
            Schema::create('suppliers', function (Blueprint $table) {
                
                $table->text('supplier_id')->nullable();
                $table->string('supplier_name');
                $table->bigInteger('order_id');
                $table->string('product_sku')->nullable() ;
                $table->string('supplier_emailid')->nullable();
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
        if (Schema::hasTable('supplier')) {
            Schema::dropIfExists('supplier');
        }
        
    }
}
