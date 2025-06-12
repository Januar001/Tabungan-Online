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
        Schema::create('pengajuan_rekening', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('nasabah_id');
            $table->string('kode_pengajuan', 20)->unique(); // Contoh: REG-20250612-0001
            $table->enum('produk', ['tabunganku', 'simade']);
            $table->enum('tipe_simade', ['perorangan', 'badan_usaha'])->nullable(); // hanya untuk produk = 'simade'
            $table->enum('penghasilan_per_bulan', ['<1jt', '1-3jt', '3-5jt', '5-10jt', '>10jt']);
            $table->string('sumber_dana', 100);
            $table->string('tujuan_penggunaan', 255);
            $table->enum('status', ['pending', 'diproses', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();

            // Foreign key
            $table->foreign('nasabah_id')->references('id')->on('nasabah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_rekening');
    }
};
