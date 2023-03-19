<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('order_number');
                $table->dateTime('order_date');
                $table->decimal('order_discount')->nullable();
                $table->decimal('shipping_total')->nullable();
                $table->decimal('order_total')->nullable();
                $table->boolean('order_gst_status')->nullable();
                $table->text('customer_first_name')->nullable();
                $table->text('customer_last_name')->nullable();
                $table->text('billing_address_street')->nullable();
                $table->text('billing_address_city')->nullable();
                $table->text('billing_address_state')->nullable();
                $table->text('billing_address_post_code')->nullable();
                $table->text('shipping_address_street')->nullable();
                $table->text('shipping_address_city')->nullable();
                $table->text('shipping_address_state')->nullable();
                $table->text('shipping_address_post_code')->nullable();
                $table->text('contact_phone_number')->nullable();
                $table->text('ndis_participant_first_name');
                $table->text('ndis_participant_last_name');
                $table->text('ndis_participant_number');
                $table->date('ndis_participant_date_of_birth');
                $table->text('ndis_plan_management_option')->nullable();
                $table->date('ndis_plan_start_date')->nullable();
                $table->date('ndis_plan_end_date')->nullable();
                $table->text('plan_manager_name')->nullable();
                $table->text('invoice_email_address')->nullable();
                $table->boolean('parent_carer_status')->nullable();
                $table->text('parent_carer_name')->nullable();
                $table->text('parent_carer_email')->nullable();
                $table->text('parent_carer_phone')->nullable();
                $table->text('parent_carer_relationship')->nullable();
                $table->text('product_category')->nullable();
                $table->text('order_status')->comment('0 = Error, 1 = Submited')->nullable();
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
        Schema::dropIfExists('orders');
    }
}