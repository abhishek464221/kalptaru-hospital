<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Razorpay, Stripe, UPI
            $table->string('type'); // qr, gateway, bank
            $table->string('mode')->default('test'); // test, live
            $table->text('key')->nullable(); // Encrypted
            $table->text('secret')->nullable(); // Encrypted
            $table->text('qr_code')->nullable(); // QR Code Image Path/Base64
            $table->string('upi_id')->nullable(); // UPI ID: hospital@bank
            $table->string('account_holder')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->json('settings')->nullable(); // currency, fee_percentage, etc.
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
};