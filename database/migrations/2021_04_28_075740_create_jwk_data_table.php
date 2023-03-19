<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJwkDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('jwk_data')) { 
            Schema::create('jwk_data', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('jwk')->nullable();
                $table->text('jwk_private')->nullable();
                $table->text('jwt_token')->nullable();
                $table->text('public_key')->nullable();
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
        Schema::dropIfExists('jwk_data');
    }
}
