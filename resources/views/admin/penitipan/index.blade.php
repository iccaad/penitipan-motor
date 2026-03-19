@extends('admin.layout')

@section('title', 'Data Penitipan')

@section('content')
<div class="flex flex-col space-y-6">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h1 class="text-lg font-bold text-gray-800 uppercase tracking-wide">Manajemen Data Penitipan</h1>
        </div>
        
        <form method="GET" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Nama</label>
                    <input type="search" name="q_nama" value="{{ request('q_nama') }}" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#1e40af] focus:border-[#1e40af] outline-none transition-all text-sm" placeholder="Nama penitip...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor Polisi (Plat)</label>
                      <div class="grid grid-cols-3 gap-3">

                                <input type="text" name="plat_prefix" value="{{ old('plat_prefix') }}" placeholder="H"
                                    maxlength="2" class="w-full border border-gray-300 rounded-lg p-2.5 text-center uppercase
                   focus:ring-2 focus:ring-[#1e40af] outline-none">

                                <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" placeholder="1234"
                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-center
                   focus:ring-2 focus:ring-[#1e40af] outline-none">

                                <input type="text" name="plat_suffix" value="{{ old('plat_suffix') }}" placeholder="AB"
                                    maxlength="3" class="w-full border border-gray-300 rounded-lg p-2.5 text-center uppercase
                   focus:ring-2 focus:ring-[#1e40af] outline-none">

                            </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kode Penitipan</label>
                    <input type="search" name="q_kode" value="{{ request('q_kode') }}" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all text-sm uppercase" placeholder="PM-YYYY-XXX">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Kendaraan</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all text-sm">
                        <option value="">Semua Status</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Masih Dititip</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sudah Selesai</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Merk Motor</label>
                    <input type="text" name="merk_motor" value="{{ request('merk_motor') }}" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all text-sm" placeholder="Honda, Yamaha...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kapasitas (CC)</label>
                    <input type="number" name="cc_motor" value="{{ request('cc_motor') }}" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all text-sm" placeholder="110, 150...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Warna</label>
                    <input type="text" name="warna_motor" value="{{ request('warna_motor') }}" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all text-sm" placeholder="Hitam, Merah...">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1">Lokasi Penitipan</label>
                    <select name="lokasi" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#1e40af] outline-none text-sm">
                        <option value="">Semua Lokasi</option>
                                    @foreach(config('polsek.list') as $lokasi)
                                        <option value="{{ $lokasi }}" {{ old('lokasi_nama') == $lokasi ? 'selected' : '' }}>
                                            {{ $lokasi }}
                                        </option>
                                    @endforeach

                    </select>
                </div>

                <div class="col-span-1 md:col-span-2 lg:col-span-4 flex justify-center gap-3 mt-4">
                    <button type="submit"
                        class="bg-[#1e40af] text-white px-6 py-2 rounded-lg font-semibold text-sm">
                        Filter Data
                    </button>

                    <a href="{{ route('admin.penitipan.index') }}"
                        class="bg-gray-200 px-6 py-2 rounded-lg font-semibold text-sm">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                        <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Foto</th>
                        <th scope="col" class="px-6 py-4 font-bold">Identitas Kendaraan</th>
                        <th scope="col" class="px-6 py-4 font-bold">Pemilik / Waktu Titip</th>
                        <th scope="col" class="px-6 py-4 font-bold">Lokasi</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Aksi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($penitipans as $item)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4">
                                @if($item->foto_motor)
                                    <img src="{{ asset('storage/' . $item->foto_motor) }}" alt="foto" class="w-16 h-16 object-cover rounded-lg border border-gray-200 shadow-sm hover:scale-110 transition-transform cursor-pointer" />
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border border-gray-200">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-base uppercase">{{ $item->nomor_polisi }}</div>
                                <div class="text-xs text-gray-500 font-medium">{{ $item->kode_penitipan }}</div>
                                <div class="text-xs text-gray-500">{{ $item->merk_motor }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $item->nama_penitip }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_titip)->format('d M Y, H:i') }}</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($item->lokasi_jenis === 'polsek' && $item->lokasi_nama)
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">Polsek - {{ $item->lokasi_nama }}</span>
                                @elseif($item->lokasi_jenis === 'polrestabes')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Polrestabes Semarang</span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($item->status == 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#facc15]/20 text-yellow-800 border border-[#facc15]/50">
                                        Dititip
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('admin.penitipan.detail', $item->id) }}" class="p-2 text-gray-600 hover:text-[#1e40af] hover:bg-blue-100 rounded-lg transition-colors" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    
                                    <a href="{{ route('admin.penitipan.edit', $item->id) }}" class="p-2 text-gray-600 hover:text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.penitipan.destroy', $item->id) }}" method="POST" class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="p-2 text-gray-600 hover:text-[#ef4444] hover:bg-red-100 rounded-lg transition-colors btn-delete" title="Hapus Data" data-kode="{{ $item->kode_penitipan }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>

                                    @if($item->status == 0)
                                    <form action="{{ route('admin.penitipan.ambil', $item->id) }}" method="POST" class="inline ml-2 border-l pl-2 border-gray-300 form-verifikasi">
                                        @csrf
                                        <button type="button" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-3 py-2 rounded-lg transition-colors shadow-sm btn-verifikasi" data-plat="{{ $item->nomor_polisi }}">
                                            Verifikasi Ambil
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="text-sm font-medium text-gray-500">Tidak ada data operasional yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $penitipans->links() }}
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfigurasi Notifikasi Hapus (Merah Taktis)
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.form-delete');
                const kode = this.getAttribute('data-kode'); // Mengambil kode unik

                Swal.fire({
                    title: 'Otorisasi Penghapusan',
                    text: `Apakah Anda yakin ingin menghapus data penitipan [${kode}] secara permanen?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Merah (tactical-red)
                    cancelButtonColor: '#6b7280',  // Abu-abu
                    confirmButtonText: 'Ya, Hapus Data',
                    cancelButtonText: 'Batalkan',
                    customClass: {
                        popup: 'rounded-2xl border-2 border-red-100 shadow-2xl',
                        title: 'font-bold text-gray-800',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika disetujui
                    }
                })
            });
        });

        // Konfigurasi Notifikasi Verifikasi (Hijau Success)
        const verifButtons = document.querySelectorAll('.btn-verifikasi');
        verifButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.form-verifikasi');
                const plat = this.getAttribute('data-plat'); // Mengambil nomor plat

                Swal.fire({
                    title: 'Verifikasi Pengambilan',
                    html: `Sistem akan mencatat bahwa kendaraan dengan plat <b>${plat}</b> telah diserahkan kembali ke pemilik.`,
                    icon: 'info',
                    iconColor: '#1e40af', // Biru Polisi
                    showCancelButton: true,
                    confirmButtonColor: '#10b981', // Hijau (Success)
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Verifikasi Sekarang',
                    cancelButtonText: 'Cek Kembali',
                    customClass: {
                        popup: 'rounded-2xl border-2 border-blue-100 shadow-2xl',
                        title: 'font-bold text-gray-800',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    });
</script>
@endpush