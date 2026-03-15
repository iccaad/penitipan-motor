<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penitipan_motor', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penitipan')->unique();
            $table->string('nama_penitip');
            $table->string('no_hp');
            $table->string('no_ktp');

            $table->string('nomor_polisi');
            $table->string('merk_motor');
            $table->string('tipe_motor');
            $table->integer('cc_motor');
            $table->string('warna_motor');

            $table->string('foto_motor');

            $table->date('tanggal_titip');
            $table->date('tanggal_rencana_ambil');

            $table->date('tanggal_ambil')->nullable();
            $table->timestamp('waktu_ambil')->nullable();

            $table->integer('status')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penitipan_motor');
    }
};
