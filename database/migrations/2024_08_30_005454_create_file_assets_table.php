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
        Schema::create('file_assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rencana_aksi_id')->nullable();
            $table->foreign('rencana_aksi_id')->references('id')->on('rencana_aksis');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_assets');
    }
};
