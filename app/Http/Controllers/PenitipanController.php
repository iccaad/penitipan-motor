<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenitipanMotor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller as BaseController;

class PenitipanController extends BaseController
{
    public function showForm()
    {
        return view('penitipan.form');
    }

    public function storePenitipan(Request $request)
    {
        $validated = $request->validate([
            'nama_penitip' => 'required|string',
            'no_hp' => 'required|string',
            'no_ktp' => 'required|string',

            // plate parts: we collect and then merge into nomor_polisi
            'plat_prefix' => 'required|string|max:2',
            'plat_nomor' => 'required|string|max:4',
            'plat_suffix' => 'required|string|max:3',

            'merk_motor' => 'required|string',
            'tipe_motor' => 'required|string',
            'cc_motor' => 'required|integer',
            'warna_motor' => 'required|string',

            'lokasi_nama' => 'required|string|max:100',

            'foto_motor' => 'required|image',
            'tanggal_titip' => 'required|date',
            'tanggal_rencana_ambil' => 'required|date',
        ]);

        // Merge plate parts into standardized nomor_polisi: "H 1234 AB"
        $prefix = strtoupper(trim($request->input('plat_prefix')));
        $nomor  = trim($request->input('plat_nomor'));
        $suffix = strtoupper(trim($request->input('plat_suffix')));

        $nomor_polisi = preg_replace('/\s+/', ' ', "$prefix $nomor $suffix");

        // Derive lokasi_jenis from chosen lokasi_nama (single dropdown)
        $lokasiNama = $validated['lokasi_nama'];
        $lokasiJenis = $lokasiNama === 'Polrestabes Semarang' ? 'polrestabes' : 'polsek';
        try {
            $imageFile = $request->file('foto_motor');

            $manager = new ImageManager(new Driver());

            $img = $manager->read($imageFile->getRealPath());

            if ($img->width() > 1280) {
                $img->scale(width: 1280);
            }

            $filename = 'motor_' . time() . '_' . random_int(1000, 9999) . '.jpg';

            $storageDir = storage_path('app/public/motor');

            if (!File::exists($storageDir)) {
                File::makeDirectory($storageDir, 0755, true);
            }

            $fullPath = $storageDir . DIRECTORY_SEPARATOR . $filename;

            $img->toJpeg(70)->save($fullPath);



            $publicPath = 'motor/' . $filename;

            $model = PenitipanMotor::create([
                'kode_penitipan' => PenitipanMotor::generateKodeTitip(),
                'nama_penitip' => $validated['nama_penitip'],
                'no_hp' => $validated['no_hp'],
                'no_ktp' => $validated['no_ktp'],

                'nomor_polisi' => $nomor_polisi,
                'merk_motor' => $validated['merk_motor'],
                'tipe_motor' => $validated['tipe_motor'],
                'cc_motor' => $validated['cc_motor'],
                'warna_motor' => $validated['warna_motor'],

                'lokasi_jenis' => $lokasiJenis,
                'lokasi_nama' => $lokasiNama,

                'foto_motor' => $publicPath,

                'tanggal_titip' => $validated['tanggal_titip'],
                'tanggal_rencana_ambil' => $validated['tanggal_rencana_ambil'],

                'tanggal_ambil' => null,
                'waktu_ambil' => null,

                'status' => 0,
            ]);

            // Redirect to success receipt page with kode_penitipan
            return redirect()->route('penitipan.sukses', $model->kode_penitipan);
        } catch (\Exception $e) {
            return back()->withErrors(['foto_motor' => 'Gagal memproses gambar atau menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Show success/receipt page after penitipan is stored.
     *
     * @param  string $kode
     */
    public function success($kode)
    {
        $data = PenitipanMotor::where('kode_penitipan', $kode)->firstOrFail();

        return view('penitipan.sukses', compact('data'));
    }
}
