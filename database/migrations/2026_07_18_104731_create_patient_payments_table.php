<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_bill_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_gateway_id')->nullable()->constrained()->onDelete('set null');
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('INR');
            $table->string('payment_method'); // qr, upi, card, cash, netbanking
            $table->string('status'); // pending, success, failed, refunded
            $table->text('response')->nullable(); // Gateway response JSON
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_payments');
    }
};