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
        Schema::create('alamat', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('nasabah_id');
            $table->enum('jenis_alamat', ['identitas', 'domisili'])->default('identitas');
            $table->text('alamat_lengkap');
            $table->char('provinsi_id', 2);
            $table->char('kabupaten_id', 4);
            $table->char('kecamatan_id', 7);
            $table->char('desa_id', 10);
            $table->string('kode_pos', 10);
            $table->timestamps();

            // Foreign key ke tabel nasabah
            $table->foreign('nasabah_id')->references('id')->on('nasabah')->onDelete('cascade');

            // Jika kamu punya tabel master wilayah, foreign key bisa ditambahkan di sini.
            // Contoh:
            // $table->foreign('provinsi_id')->references('id')->on('provinsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
