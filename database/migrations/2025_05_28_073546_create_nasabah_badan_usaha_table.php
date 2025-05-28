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
        Schema::create('nasabah_badan_usaha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabah')->onDelete('cascade');
            $table->string('nama_perusahaan', 100);
            $table->string('no_akta_pendirian', 50)->nullable();
            $table->string('no_izin_usaha', 50)->nullable();
            $table->string('npwp_perusahaan', 20);
            $table->string('jabatan', 50);
            $table->string('no_telp_perusahaan', 20);
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
        Schema::dropIfExists('nasabah_badan_usaha');
    }
};
