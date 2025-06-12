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
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id(); // sama dengan BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('nama_lengkap');
            $table->string('nama_panggilan', 100)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nama_ibu_kandung');
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('agama', ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'lainnya']);
            $table->enum('pendidikan_terakhir', ['sd', 'smp', 'sma', 'diploma', 's1', 's2', 's3', 'lainnya']);
            $table->enum('status_perkawinan', ['belum_menikah', 'menikah', 'janda', 'duda']);
            $table->string('pekerjaan', 100);
            $table->string('npwp', 25)->nullable();
            $table->string('no_telepon', 20);
            $table->timestamps(); // otomatis buat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};
