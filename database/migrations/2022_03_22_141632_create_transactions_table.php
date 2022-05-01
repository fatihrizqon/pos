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
            $table->id();
            $table->string('order_code',100)->unique()->references('code')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('revenue');
            $table->bigInteger('pay');
            $table->bigInteger('return');
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('status')->default(0);
            $table->timestamps();
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
