<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'patient_type')) {
                $table->enum('patient_type', ['OPD', 'IPD', 'ICU'])->nullable()->after('medical_history');
            } else {
                $table->enum('patient_type', ['OPD', 'IPD', 'ICU'])->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('patient_type');
        });
    }
};