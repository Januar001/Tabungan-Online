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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key auto-incrementing BIGINT
            $table->unsignedBigInteger('nasabah_id');
            $table->enum('jenis', ['KTP', 'foto_selfie', 'akta', 'lain_lain']); // Tambahkan 'lain_lain' atau sesuaikan
            $table->string('path', 255);
            $table->string('original_name', 255);
            $table->timestamps(); // Untuk created_at dan updated_at

            // Foreign key constraint
            $table->foreign('nasabah_id')->references('id')->on('nasabah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
