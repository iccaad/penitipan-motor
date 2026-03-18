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
        Schema::table('penitipan_motor', function (Blueprint $table) {
            $table->string('lokasi_jenis')->nullable()->after('warna_motor');
            $table->string('lokasi_nama')->nullable()->after('lokasi_jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penitipan_motor', function (Blueprint $table) {
            $table->dropColumn(['lokasi_jenis', 'lokasi_nama']);
        });
       
    }
};
