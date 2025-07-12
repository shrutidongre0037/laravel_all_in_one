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
        Schema::create('development_project', function (Blueprint $table) {
            $table->uuid('development_id');
    $table->uuid('project_id');

    $table->foreign('development_id')->references('id')->on('developments')->onDelete('cascade');
    $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

    $table->primary(['development_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('development_project');
    }
};
