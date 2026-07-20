<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->string('bill_number')->unique();
            $table->date('bill_date');
            $table->date('due_date')->nullable();
            
            // Charges
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->decimal('room_charges', 10, 2)->default(0);
            $table->decimal('medicine_charges', 10, 2)->default(0);
            $table->decimal('lab_charges', 10, 2)->default(0);
            $table->decimal('operation_charges', 10, 2)->default(0);
            $table->decimal('other_charges', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2);
            
            // Payment
            $table->enum('payment_status', ['pending', 'paid', 'partially_paid', 'failed'])->default('pending');
            $table->string('payment_method')->nullable(); // QR, UPI, Card, Cash
            $table->string('transaction_id')->nullable();
            $table->text('payment_response')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_bills');
    }
};