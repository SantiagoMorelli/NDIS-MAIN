<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingOrderProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('trackingOrderProgress')) {
            Schema::create('trackingOrderProgress', function (Blueprint $table) {
                //
                $table->id();
                $table->string('trackingInterval')->default('5')->comment('day');
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
        if (Schema::hasTable('trackingOrderProgress')) {
           
           
            Schema::dropIfExists('tracking_order_progress');
        }
    }
}
