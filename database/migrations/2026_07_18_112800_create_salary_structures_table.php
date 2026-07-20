<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('salary_structures')) {
            Schema::create('salary_structures', function (Blueprint $table) {
                $table->id();
                $table->morphs('employee'); 
                $table->decimal('base_salary', 10, 2)->default(0);
                $table->string('payment_frequency')->default('monthly');
                $table->json('allowances')->nullable();
                $table->json('deductions')->nullable();
                $table->json('variable_components')->nullable();
                $table->date('effective_from');
                $table->date('effective_to')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('salary_structures');
    }
};