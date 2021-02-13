<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->comment('receiver');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('referral_id')->comment('sender');;
            $table->foreign('referral_id')->references('id')->on('users');
            $table->unsignedBigInteger('sell_id');
            $table->foreign('sell_id')->references('id')->on('sells')->onDelete('cascade');
            $table->double('amount');
            $table->integer('level');
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
        Schema::dropIfExists('referral_earnings');
    }
}
