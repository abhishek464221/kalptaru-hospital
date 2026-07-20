<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->morphs('employee');
            $table->foreignId('salary_structure_id')->constrained()->onDelete('cascade');
            $table->string('month_year'); // 2024-01
            $table->decimal('total_earnings', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            $table->decimal('net_payable', 10, 2)->default(0);
            $table->enum('status', ['draft', 'approved', 'paid', 'cancelled'])->default('draft');
            $table->date('payment_date')->nullable();
            $table->foreignId('payment_gateway_id')->nullable()->constrained()->onDelete('set null');
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
};