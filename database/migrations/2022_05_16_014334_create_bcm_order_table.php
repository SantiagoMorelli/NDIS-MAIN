<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcmOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     if (!Schema::hasTable('bcm_order')) {
                Schema::create('bcm_order', function (Blueprint $table) {
                    $table->bigInteger('order_number')->unique();
                    $table->dateTime('order_date');
                    $table->decimal('order_discount', $precision = 8, $scale = 2)->nullable();
                    $table->decimal('shipping_total', $precision = 8, $scale = 2)->nullable();
                    $table->decimal('order_total', $precision = 8, $scale = 2)->nullable();
                    $table->decimal('gst_total', $precision = 8, $scale = 2)->nullable();
                    $table->integer('order_gst_status')->nullable();
                    $table->text('customer_first_name')->nullable();
                    $table->text('customer_last_name')->nullable();
                    $table->string('customer_email');
                    $table->string('customer_phone_number');
                    $table->text('order_comment')->nullable();
                    $table->text('billing_address_first_name')->nullable();
                    $table->text('billing_address_last_name')->nullable();
                    $table->text('billing_address_company')->nullable();
                    $table->text('billing_address_street')->nullable();
                    $table->text('billing_address_city')->nullable();
                    $table->text('billing_address_state')->nullable();
                    $table->text('billing_address_post_code')->nullable();
                    $table->text('shipping_address_first_name')->nullable();
                    $table->text('shipping_address_last_name')->nullable();
                    $table->text('shipping_address_company')->nullable();
                    $table->text('shipping_address_street')->nullable();
                    $table->text('shipping_address_city')->nullable();
                    $table->text('shipping_address_state')->nullable();
                    $table->text('shipping_address_post_code')->nullable();
                    $table->text('contact_phone_number')->nullable();
                    $table->text('invoice_email_address')->nullable();
                    $table->text('payment_option')->nullable();
                    $table->text('product_category')->nullable();
                    $table->text('order_status')->nullable()->comment(`'0' => 'Error', '1' => 'Pending', '2' => 'Paid', '3' => 'Processed By BCM', '4' => 'Supplier Order Pending ', '5' => 'Processed by Supplier', '6' => 'Tracking Code Received', '7' => 'Delivered', '8' => 'Returned'`);
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
        if (Schema::hasTable('bcm_order')) {
            Schema::dropIfExists('bcm_order');
        }
        
    }
}
