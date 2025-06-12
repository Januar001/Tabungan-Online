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
        Schema::create('data_tabunganku', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY

            $table->foreignId('pengajuan_rekening_id')
                  ->unique()
                  ->constrained('pengajuan_rekening')
                  ->onDelete('cascade'); // FOREIGN KEY + UNIQUE + ON DELETE CASCADE

            $table->string('nama_sekolah');
            $table->string('kelas', 50);
            $table->string('nama_wali');
            $table->string('no_identitas_wali', 50);
            $table->string('hubungan_wali', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_tabunganku');
    }
};
