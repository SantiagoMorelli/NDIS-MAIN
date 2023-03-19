<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceAuthenticationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('device_authentication')) {
            Schema::create('device_authentication', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('access_token')->nullable();
                $table->dateTime('token_expiry')->nullable();
                $table->integer('expires_in')->comment('Expire in seconds')->nullable();
                $table->dateTime('device_expiry')->nullable();
                $table->dateTime('key_expiry')->nullable();
                $table->string('token_type')->nullable();
                $table->string('scope')->nullable();
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
        Schema::dropIfExists('device_authentication');
    }
}
