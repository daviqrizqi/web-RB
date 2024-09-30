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
        Schema::create('permasalahans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('unique_namespace')->nullable();
            $table->foreignUuid('erb_type_id')->nullable();
            $table->foreign('erb_type_id')->references('id')->on('erb_types');
            $table->foreignUuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('permasalahan')->nullable();
            $table->text('sasaran')->nullable();
            $table->text('indikator')->nullable();
            $table->string('target')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permasalahans');
    }
};