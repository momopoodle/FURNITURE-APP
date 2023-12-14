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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->integer('total');
            $table->string('full_name');
            $table->string('email');
            $table->string('status')->default('pending');
            $table->string('phone_number');
            $table->foreignId('billing_id')->constrained('addresses','id');
            $table->foreignId('shipping_id')->constrained('addresses','id');
            $table->foreignId('payment_id')->constrained('payments','id');
            
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
        Schema::dropIfExists('orders');
    }
};
