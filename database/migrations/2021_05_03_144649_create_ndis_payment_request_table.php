<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdisPaymentRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ndis_payment_request')) {
            Schema::create('ndis_payment_request', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('ndis_service_booking_id')->index();
                $table->bigInteger('orders_id')->index();
                $table->bigInteger('order_item_id')->index();
                $table->text('claim_number')->nullable();
                $table->tinyInteger('status')->comment('0 = Rejected, 1 = Incomplete, 4 = Pending Payment, 41 = Paid, 42 = Cancelled, 7 = Awaiting Approval')->nullable();
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
        Schema::dropIfExists('ndis_payment_request');
    }
}
