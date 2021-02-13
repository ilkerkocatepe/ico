<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
            $table->unsignedBigInteger('method_id');
            $table->foreign('method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->integer('sellable_id');
            $table->string('sellable_type');
            $table->double('amount');
            $table->double('price');
            $table->double('total');
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
        Schema::dropIfExists('sells');
    }
}
