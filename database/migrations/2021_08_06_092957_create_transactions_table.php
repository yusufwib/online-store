<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
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
            $table->unsignedInteger('id_cart');
            $table->unsignedInteger('id_user');
            $table->string('inv');
            $table->unsignedInteger('id_bank')->nullable();
            $table->string('payment_expired')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('order_note')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('status')->default('PENDING'); //pending, invalid, unpaid, waiting, process, delivery, cancelled
            $table->string('id_address_send')->nullable();
            $table->text('payment_image')->nullable();
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
}
