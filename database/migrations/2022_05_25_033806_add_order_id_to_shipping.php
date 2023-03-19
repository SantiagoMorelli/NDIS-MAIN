<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToShipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('shipping') && !Schema::hasColumn('shipping','order_number')) {
            Schema::table('shipping', function (Blueprint $table) {
                //
                $table->text('order_number')->nullable();
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
        if (Schema::hasTable('shipping') && Schema::hasColumn('shipping','order_number')) {
            
            Schema::table('shipping', function (Blueprint $table) {
                //
                $table->dropColumn(['order_number']);
            });
        }
    }
}
