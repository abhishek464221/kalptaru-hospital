<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['attachment', 'attachment_type']);
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->json('attachment')->nullable();
            $table->json('attachment_type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['attachment', 'attachment_type']);
        });
        Schema::table('chats', function (Blueprint $table) {
            $table->string('attachment')->nullable();
            $table->string('attachment_type')->nullable();
        });
    }
};