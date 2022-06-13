<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('value', 10, 2);
            $table->enum('status', ['approved', 'on_hold', 'rejected', 'done']);
            $table->unsignedBigInteger('payer');
            $table->unsignedBigInteger('payee');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();

            $table->foreign('payer')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('payee')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
