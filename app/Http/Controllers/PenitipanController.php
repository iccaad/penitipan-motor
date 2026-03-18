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

            'nomor_polisi' => 'required|string',
            'merk_motor' => 'required|string',
            'tipe_motor' => 'required|string',
            'cc_motor' => 'required|integer',
            'warna_motor' => 'required|string',

            'lokasi_jenis' => 'required|in:polsek,polrestabes',
            'lokasi_nama' => 'required_if:lokasi_jenis,polsek|nullable|string|max:100',

            'foto_motor' => 'required|image',
            'tanggal_titip' => 'required|date',
            'tanggal_rencana_ambil' => 'required|date',
        ]);

        // Ensure lokasi_nama is always set. If polrestabes, override name.
        // Normalize & enforce lokasi
         if ($validated['lokasi_jenis'] === 'polrestabes') {
             $validated['lokasi_nama'] = 'Polrestabes Semarang';
                 } else {
                     if (empty($validated['lokasi_nama'])) {
                         return back()->withErrors(['lokasi_nama' => 'Nama polsek wajib diisi.']);
                     }

                     $validated['lokasi_nama'] = ucwords(strtolower($validated['lokasi_nama']));
                }
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

                'nomor_polisi' => $validated['nomor_polisi'],
                'merk_motor' => $validated['merk_motor'],
                'tipe_motor' => $validated['tipe_motor'],
                'cc_motor' => $validated['cc_motor'],
                'warna_motor' => $validated['warna_motor'],

                'lokasi_jenis' => $validated['lokasi_jenis'],
                'lokasi_nama' => $validated['lokasi_nama'],

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
