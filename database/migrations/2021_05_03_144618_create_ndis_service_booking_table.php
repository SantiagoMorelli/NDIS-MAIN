<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdisServiceBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ndis_service_booking')) {
            Schema::create('ndis_service_booking', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('orders_id')->index();
                $table->text('service_booking_id')->nullable();
                $table->tinyInteger('status')->comment('1 = Requested, 2 = Delete')->nullable();
                $table->text('api_response')->nullable();
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
        Schema::dropIfExists('ndis_service_booking');
    }
}
