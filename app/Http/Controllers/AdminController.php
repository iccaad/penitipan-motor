<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PenitipanMotor;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }
public function authenticate(Request $request)
{
    $username = $request->input('username');
    $password = $request->input('password');

    // login sederhana
    if ($username === 'admin' && $password === 'admin123') {

        session(['admin_logged_in' => true]);

        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'login' => 'Username atau password salah.'
    ]);
}
    public function dashboard()
    {
        $total = PenitipanMotor::count();
        $sedang = PenitipanMotor::where('status', 0)->count();
        $sudah = PenitipanMotor::where('status', 1)->count();
        $terlambat = PenitipanMotor::where('status', 0)
            ->whereDate('tanggal_rencana_ambil', '<', Carbon::today())
            ->count();

        $latestPenitipan = PenitipanMotor::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('total', 'sedang', 'sudah', 'terlambat', 'latestPenitipan'));
    }

    /**
     * Show detail page for a penitipan record.
     */
    public function detail($id)
    {
        $item = PenitipanMotor::findOrFail($id);
        return view('admin.penitipan.detail', compact('item'));
    }

    /**
     * Show edit form for a penitipan record.
     */
    public function edit($id)
    {
        $item = PenitipanMotor::findOrFail($id);
        return view('admin.penitipan.edit', compact('item'));
    }

    /**
     * Update penitipan record.
     */
    public function update(Request $request, $id)
    {
    $item = PenitipanMotor::findOrFail($id);

    $validated = $request->validate([
        'nama_penitip' => 'required|string',
        'no_hp' => 'required|string',
        'plat_prefix' => 'required|string|max:2',
        'plat_nomor' => 'required|string|max:4',
        'plat_suffix' => 'required|string|max:3',
        'merk_motor' => 'required|string',
        'tipe_motor' => 'required|string',
        'cc_motor' => 'required|integer',
        'warna_motor' => 'required|string',
        'tanggal_rencana_ambil' => 'required|date',

        
        'lokasi_nama' => 'required|in:' . implode(',', config('polsek.list')),
    ]);

    // derive otomatis 
    $lokasiNama = $validated['lokasi_nama'];

    $lokasiJenis = $lokasiNama === 'Polrestabes Semarang'
        ? 'polrestabes'
        : 'polsek';
    // Merge plate parts into standardized nomor_polisi
    $prefix = strtoupper(trim($validated['plat_prefix']));
    $nomor  = trim($validated['plat_nomor']);
    $suffix = strtoupper(trim($validated['plat_suffix']));

    $nomor_polisi = preg_replace('/\s+/', ' ', "$prefix $nomor $suffix");

    $item->update([
        'nama_penitip' => $validated['nama_penitip'],
        'no_hp' => $validated['no_hp'],
        'nomor_polisi' => $nomor_polisi,
        'merk_motor' => $validated['merk_motor'],
        'tipe_motor' => $validated['tipe_motor'],
        'cc_motor' => $validated['cc_motor'],
        'warna_motor' => $validated['warna_motor'],
        'tanggal_rencana_ambil' => $validated['tanggal_rencana_ambil'],

        'lokasi_nama' => $lokasiNama,
        'lokasi_jenis' => $lokasiJenis,
    ]);

    return redirect()
        ->route('admin.penitipan.index')
        ->with('success', 'Data penitipan berhasil diperbarui.');
    }

    /**
     * Destroy penitipan record.
     */
    public function destroy($id)
    {
        $item = PenitipanMotor::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.penitipan.index')->with('success', 'Data penitipan berhasil dihapus.');
    }

    public function listPenitipan(Request $request)
    {
        $query = PenitipanMotor::query();

        // Search
        $query->when($request->input('q_nama'), function ($q, $v) {
            $q->where('nama_penitip', 'ilike', "%{$v}%");
        });

        $query->when($request->input('q_nomor'), function ($q, $v) {
            $q->where('nomor_polisi', 'ilike', "%{$v}%");
        });

        $query->when($request->input('q_kode'), function ($q, $v) {
            $q->where('kode_penitipan', 'ilike', "%{$v}%");
        });

        // Plate-part filtering: allow searching by prefix/number/suffix combination
        $query->when(
            $request->filled('plat_prefix') ||
            $request->filled('plat_nomor') ||
            $request->filled('plat_suffix'),
            function ($q) use ($request) {

                $prefix = strtoupper(trim($request->plat_prefix ?? ''));
                $nomor  = trim($request->plat_nomor ?? '');
                $suffix = strtoupper(trim($request->plat_suffix ?? ''));

                $pattern = trim("$prefix $nomor $suffix");

                if ($pattern !== '') {
                    $q->where('nomor_polisi', 'like', "%$pattern%");
                }
            }
        );

        // Filters
        $query->when($request->input('merk_motor'), function ($q, $v) {
            $q->where('merk_motor', $v);
        });

        $query->when($request->input('cc_motor'), function ($q, $v) {
            $q->where('cc_motor', $v);
        });

        $query->when($request->input('warna_motor'), function ($q, $v) {
            $q->where('warna_motor', $v);
        });

        $query->when($request->input('status') !== null && $request->input('status') !== '', function ($q) use ($request) {
            $q->where('status', $request->input('status'));
        });

        // Filter by a single lokasi dropdown (Polrestabes or specific Polsek)
        $query->when($request->filled('lokasi'), function ($q) use ($request) {
            $q->where('lokasi_nama', $request->lokasi);
        });

        $penitipans = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.penitipan.index', compact('penitipans'));
    }

    public function verifikasiPengambilan($id)
    {
        $item = PenitipanMotor::findOrFail($id);

        $item->update([
            'status' => 1,
            'tanggal_ambil' => Carbon::today(),
            'waktu_ambil' => Carbon::now(),
        ]);
        $item->save();

        return redirect()->back()->with('success', 'Verifikasi pengambilan berhasil.');
    }

    public function statistik()
    {
        $data = [
            'sedang_dititip' => PenitipanMotor::where('status', 0)->count(),
            'sudah_diambil' => PenitipanMotor::where('status', 1)->count(),
            'terlambat_diambil' => PenitipanMotor::where('status', 0)
                ->whereDate('tanggal_rencana_ambil', '<', Carbon::today())
                ->count(),
        ];

        return response()->json($data);
    }
}
