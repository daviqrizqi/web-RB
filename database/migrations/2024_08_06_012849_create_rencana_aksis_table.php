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
        Schema::create('rencana_aksis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('unique_namespace')->nullable();
            $table->foreignUuid('permasalahan_id')->nullable();
            $table->foreign('permasalahan_id')->references('id')->on('permasalahans');
            $table->foreignUuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('rencana_aksi')->nullable()->comment('ouput');
            $table->text('indikator')->nullable()->comment('output');
            $table->text('satuan')->nullable();
            $table->string('koordinator')->nullable()->comment('unit_pelaksana');
            $table->string('pelaksana')->nullable()->commnet('unit_pelaksana');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_aksis');
    }
};