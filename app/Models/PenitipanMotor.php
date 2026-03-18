<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenitipanMotor extends Model
{
    use HasFactory;

    protected $table = 'penitipan_motor';

    protected $fillable = [
        'kode_penitipan',
        'nama_penitip',
        'no_hp',
        'no_ktp',
        'nomor_polisi',
        'merk_motor',
        'tipe_motor',
        'cc_motor',
        'warna_motor',
        'foto_motor',
        'tanggal_titip',
        'tanggal_rencana_ambil',
        'tanggal_ambil',
        'waktu_ambil',
        'status',
        'lokasi_jenis',
        'lokasi_nama',
    ];

    public static function generateKodeTitip(): string
    {
        $year = date('Y');
        $prefix = "PM-{$year}-";

        $last = static::where('kode_penitipan', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->value('kode_penitipan');

        if ($last) {
            $parts = explode('-', $last);
            $lastNumber = intval(end($parts));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $increment = str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

        return $prefix . $increment;
    }
}
