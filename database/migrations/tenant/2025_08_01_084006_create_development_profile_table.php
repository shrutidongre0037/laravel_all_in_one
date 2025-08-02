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
        Schema::connection('tenant')->create('development_profile', function (Blueprint $table) {            
            $table->uuid('id')->primary();
            $table->uuid('development_id')->unique(); 
            $table->uuid('profile_id')->unique();  
            $table->timestamps();

            $table->foreign('development_id')->references('id')->on('developments')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('development_profile');
    }
};
