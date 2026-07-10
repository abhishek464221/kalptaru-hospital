<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->string('caller_name')->nullable();
            $table->string('receiver_name')->nullable();
            $table->dateTime('call_datetime');
            $table->integer('duration_seconds')->default(0);
            $table->enum('call_type', ['audio', 'video', 'missed'])->default('audio');
            $table->enum('direction', ['incoming', 'outgoing'])->default('outgoing');
            $table->text('notes')->nullable();
            $table->boolean('follow_up_required')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};