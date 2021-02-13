<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_pays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gateway_id');
            $table->foreign('gateway_id')->references('id')->on('crypto_gateways')->onDelete('cascade');
            $table->unsignedBigInteger('external_wallet_id');
            $table->foreign('external_wallet_id')->references('id')->on('external_wallets');
            $table->double('payable');
            $table->double('current_value');
            $table->string('txhash');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_pays');
    }
}
