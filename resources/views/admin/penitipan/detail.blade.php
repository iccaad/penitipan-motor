@extends('admin.layout')

@section('title', 'Detail Investigasi Data')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.penitipan.index') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-[#1e40af] transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <div class="flex space-x-3">
            <a href="{{ route('admin.penitipan.edit', $item->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition-colors shadow-sm">
                Edit Data
            </a>
            @if($item->status == 0)
                <form action="{{ route('admin.penitipan.ambil', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                        Verifikasi Ambil
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-black text-gray-800 tracking-tight">{{ $item->kode_penitipan }}</h1>
                <p class="text-sm text-gray-500 mt-1">Dicatat pada: {{ \Carbon\Carbon::parse($item->tanggal_titip)->format('d F Y, H:i') }}</p>
            </div>
            <div>
                @if($item->status == 0)
                    <span class="px-4 py-2 rounded-lg text-sm font-bold bg-[#facc15]/20 text-yellow-800 border border-[#facc15]/50 uppercase tracking-widest">
                        Status: Dititip
                    </span>
                @else
                    <span class="px-4 py-2 rounded-lg text-sm font-bold bg-green-100 text-green-800 border border-green-300 uppercase tracking-widest">
                        Status: Selesai
                    </span>
                @endif
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Dokumentasi Fisik</h3>
                    <div class="bg-gray-100 p-2 rounded-xl border-2 border-dashed border-gray-300">
                        @if($item->foto_motor)
                            <img src="{{ asset('storage/' . $item->foto_motor) }}" alt="foto" class="w-full h-auto rounded-lg shadow-sm" />
                        @else
                            <div class="aspect-square flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-medium">Foto tidak dilampirkan</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Identitas Pemilik</h3>
                        <dl class="space-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500 font-medium">Nama Lengkap Penitip</dt>
                                <dd class="font-bold text-gray-900 text-lg">{{ $item->nama_penitip }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Nomor KTP (NIK)</dt>
                                <dd class="font-semibold text-gray-800 font-mono">{{ $item->no_ktp ?? 'Tidak tercatat' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Nomor Handphone</dt>
                                <dd class="font-semibold text-gray-800">{{ $item->no_hp }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Spesifikasi Kendaraan</h3>
                        <dl class="space-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500 font-medium">Nomor Polisi</dt>
                                <dd class="font-black text-[#1e40af] text-xl uppercase">{{ $item->nomor_polisi }}</dd>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-gray-500 font-medium">Merk / Tipe</dt>
                                    <dd class="font-semibold text-gray-800">{{ $item->merk_motor }} {{ $item->tipe_motor }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500 font-medium">Kapasitas (CC)</dt>
                                    <dd class="font-semibold text-gray-800">{{ $item->cc_motor }}</dd>
                                </div>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Warna Fisik</dt>
                                <dd class="font-semibold text-gray-800">{{ $item->warna_motor }}</dd>
                            </div>
                            <div class="pt-2">
                                <dt class="text-gray-500 font-medium text-xs">Batas Rencana Pengambilan</dt>
                                <dd class="font-bold text-red-600">{{ \Carbon\Carbon::parse($item->tanggal_rencana_ambil)->format('d F Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection