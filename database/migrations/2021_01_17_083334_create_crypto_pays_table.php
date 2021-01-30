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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->unsignedBigInteger('gateway_id');
            $table->foreign('gateway_id')->references('id')->on('crypto_gateways')->onDelete('cascade');
            $table->unsignedBigInteger('external_wallet_id');
            $table->foreign('external_wallet_id')->references('id')->on('external_wallets');
            $table->double('amount');
            $table->double('price');
            $table->double('total');
            $table->double('payable');
            $table->double('current_value');
            $table->string('txhash');
            $table->string('user_note')->nullable();
            $table->string('admin_note')->nullable();
            $table->enum('status',['pending','rejected','confirmed','canceled'])->default('pending');
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
