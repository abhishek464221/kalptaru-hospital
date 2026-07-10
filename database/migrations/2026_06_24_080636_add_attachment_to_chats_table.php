<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('chats', function ($table) {
        $table->string('attachment')->nullable();
        $table->string('attachment_type')->nullable();
    });
}

public function down()
{
    Schema::table('chats', function ($table) {
        $table->dropColumn(['attachment', 'attachment_type']);
    });
}
};
