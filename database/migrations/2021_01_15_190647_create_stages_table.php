<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('amount');
            $table->integer('softcap')->nullable();
            $table->integer('hardcap')->nullable();
            $table->integer('min_buy')->nullable();
            $table->integer('max_buy')->nullable();
            $table->enum('price_type',['fixed','variable'])->default('fixed');
            $table->double('fixed_price')->nullable();
            $table->enum('bonus_status',['0','1'])->default('0');
            $table->integer('bonus_minimum')->nullable();
            $table->integer('bonus_rate')->nullable();
            $table->enum('status',['pending','running','done','canceled'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
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
        Schema::dropIfExists('stages');
    }
}
