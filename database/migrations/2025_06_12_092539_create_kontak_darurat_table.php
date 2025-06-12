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
        Schema::create('kontak_darurat', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY

            $table->unsignedBigInteger('pengajuan_rekening_id');
            $table->foreign('pengajuan_rekening_id')
                  ->references('id')
                  ->on('pengajuan_rekening')
                  ->onDelete('cascade');

            $table->string('nama_lengkap');
            $table->string('hubungan', 100);
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak_darurat');
    }
};
