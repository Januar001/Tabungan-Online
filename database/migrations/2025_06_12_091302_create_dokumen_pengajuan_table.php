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
        Schema::create('dokumen_pengajuan', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('pengajuan_rekening_id')
                  ->constrained('pengajuan_rekening')
                  ->onDelete('cascade'); // FOREIGN KEY + ON DELETE CASCADE

            $table->enum('jenis_dokumen', [
                'identitas_pribadi',
                'selfie_identitas',
                'akta_perusahaan',
                'npwp_perusahaan',
            ]);

            $table->string('path_file'); // Contoh: 'uploads/dokumen/namafile.pdf'
            $table->string('nama_asli_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pengajuan');
    }
};
