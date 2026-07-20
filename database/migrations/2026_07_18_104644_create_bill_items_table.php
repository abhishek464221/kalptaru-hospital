<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_bill_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->string('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('category')->nullable(); // consultation, medicine, lab, room, operation
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_items');
    }
};