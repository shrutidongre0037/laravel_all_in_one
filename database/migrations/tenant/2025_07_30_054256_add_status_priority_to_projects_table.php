<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('tenant')->table('projects', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('end_date');
            $table->string('priority')->default('medium')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->table('projects', function (Blueprint $table) {
        $table->dropColumn(['status', 'priority']);
    });
    }
};
