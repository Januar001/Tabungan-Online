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
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('nama_panggilan', 50)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nama_ibu_kandung', 100);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya']);
            $table->enum('pendidikan', ['SD', 'SMP', 'SMA/K', 'Diploma', 'S1', 'S2', 'S3', 'Lainnya']);
            $table->enum('jenis_identitas', ['KTP', 'Kartu Pelajar', 'SIM']);
            $table->string('no_identitas', 30)->unique();
            $table->text('alamat_identitas');
            $table->text('alamat_domisili');
            $table->string('kode_pos', 10);
            $table->string('kota', 50);
            $table->string('no_telp', 20);
            $table->enum('status', ['Lajang', 'Menikah', 'Duda/Janda']);
            $table->string('npwp', 20)->nullable();
            $table->enum('pekerjaan', ['PNS', 'TNI/POLRI', 'Wiraswasta', 'Karyawan Swasta', 'Pelajar/Mahasiswa', 'Ibu Rumah Tangga', 'Lainnya']);
            $table->enum('penghasilan', ['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '> 10 juta', 'Tidak Berpenghasilan']);
            $table->enum('sumber_dana', ['Penghasilan Sendiri', 'Penghasilan Orang Tua', 'Warisan', 'Hibah', 'Lainnya']);
            $table->timestamps();
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
