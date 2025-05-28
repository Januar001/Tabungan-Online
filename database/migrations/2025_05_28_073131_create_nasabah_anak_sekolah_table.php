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
        Schema::create('nasabah_anak_sekolah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabah')->onDelete('cascade');
            $table->string('nama_sekolah', 100);
            $table->string('kelas', 10);
            $table->string('nama_wali', 100);
            $table->string('no_identitas_wali', 30);
            $table->string('hubungan_wali', 20);
            $table->timestamps();
            
            // Index untuk foreign key
            $table->index('nasabah_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah_anak_sekolah');
    }
};
