<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
                'key' => 'company_name',
                'value' => 'My Hospital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'company_description',
                'value' => 'Your trusted healthcare partner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'company_mobile',
                'value' => '+91-1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'company_email',
                'value' => 'info@myhospital.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'company_address',
                'value' => '123, Main Street, City, State - 123456',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'logo_header',
                'value' => 'logo-header.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'logo_footer',
                'value' => 'logo-footer.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/myhospital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/myhospital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/myhospital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/myhospital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};