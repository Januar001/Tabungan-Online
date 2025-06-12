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
        Schema::create('data_badan_usaha', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY

            // Relasi ke pengajuan_rekening, 1 pengajuan hanya boleh punya 1 data badan usaha
            $table->unsignedBigInteger('pengajuan_rekening_id')->unique();
            $table->foreign('pengajuan_rekening_id')
                  ->references('id')
                  ->on('pengajuan_rekening')
                  ->onDelete('cascade');

            $table->string('nama_perusahaan');
            $table->string('no_akta_pendirian', 100)->nullable();
            $table->string('no_izin_usaha', 100)->nullable();
            $table->string('npwp_perusahaan', 25);
            $table->string('jabatan_pengurus', 100);
            $table->string('no_telepon_perusahaan', 20);
            $table->string('bidang_usaha', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_badan_usaha');
    }
};
