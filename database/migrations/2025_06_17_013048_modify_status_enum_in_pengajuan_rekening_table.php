<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE pengajuan_rekening MODIFY COLUMN status ENUM('pending', 'diproses', 'disetujui', 'ditolak', 'menunggu_pembayaran', 'aktif') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pengajuan_rekening MODIFY COLUMN status ENUM('pending', 'diproses', 'disetujui', 'ditolak') NOT NULL DEFAULT 'pending'");
    }
};
