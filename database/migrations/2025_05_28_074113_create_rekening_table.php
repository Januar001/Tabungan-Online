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
        Schema::create('rekening', function (Blueprint $table) {
            $table->string('no_rekening', 20)->primary();
            $table->unsignedBigInteger('nasabah_id');
            $table->unsignedBigInteger('produk_tabungan_id');
            $table->decimal('saldo', 15, 2)->default(0.00);
            $table->date('tgl_buka');
            $table->enum('status', ['aktif', 'nonaktif', 'diblokir'])->default('aktif');
            $table->string('cabang_pembuka', 50);
            $table->timestamps(); // Untuk created_at dan updated_at

            // Foreign key constraints
            $table->foreign('nasabah_id')->references('id')->on('nasabah')->onDelete('cascade');
            $table->foreign('produk_tabungan_id')->references('id')->on('produk_tabungan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening');
    }
};
