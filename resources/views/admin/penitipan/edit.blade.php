@extends('admin.layout')

@section('title', 'Koreksi Data Penitipan')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="flex items-center mb-6">
            <a href="{{ route('admin.penitipan.index') }}"
                class="flex items-center text-sm font-medium text-gray-500 hover:text-[#1e40af] transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Batal & Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-[#1e40af] px-6 py-4">
                <h1 class="text-lg font-bold text-white tracking-wide">Koreksi Data: {{ $item->kode_penitipan }}</h1>
                <p class="text-blue-200 text-sm mt-1">Hanya lakukan perubahan jika terdapat kesalahan input dari pengguna.
                </p>
            </div>

            <form action="{{ route('admin.penitipan.update', $item->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-800 border-b border-gray-200 pb-2">Informasi Kepemilikan</h3>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_penitip" value="{{ old('nama_penitip', $item->nama_penitip) }}"
                                required @class([
                                    'w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all',
                                    'border-red-500 ring-2 ring-red-200' => $errors->has('nama_penitip'),
                                    'border-gray-300' => !$errors->has('nama_penitip')
                                ])>
                            @error('nama_penitip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Handphone</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $item->no_hp) }}" required
                                class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor KTP</label>
                            <input type="text" name="no_ktp" value="{{ old('no_ktp', $item->no_ktp) }}"
                                class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all">
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium mb-1">Lokasi Penitipan</label>
                            <select name="lokasi_nama" required class="w-full border rounded-lg p-2">
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach(config('polsek.list') as $lokasi)
                                    <option value="{{ $lokasi }}" {{ old('lokasi_nama', $item->lokasi_nama) == $lokasi ? 'selected' : '' }}>
                                        {{ $lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-800 border-b border-gray-200 pb-2">Spesifikasi Kendaraan</h3>

                        <div>
                            @php
                                $parts = explode(' ', $item->nomor_polisi);
                                $prefix = $parts[0] ?? '';
                                $nomor = $parts[1] ?? '';
                                $suffix = $parts[2] ?? '';
                            @endphp
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Nomor Polisi
                                </label>

                                <div class="grid grid-cols-3 gap-3">

                                    <input type="text" name="plat_prefix" value="{{ old('plat_prefix', $prefix) }}"
                                        placeholder="H" maxlength="2"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-center uppercase focus:ring-2 focus:ring-[#1e40af] outline-none">

                                    <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $nomor) }}"
                                        placeholder="1234"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-center focus:ring-2 focus:ring-[#1e40af] outline-none">

                                    <input type="text" name="plat_suffix" value="{{ old('plat_suffix', $suffix) }}"
                                        placeholder="AB" maxlength="3"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-center uppercase focus:ring-2 focus:ring-[#1e40af] outline-none">

                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Merk</label>
                                <input type="text" name="merk_motor" value="{{ old('merk_motor', $item->merk_motor) }}"
                                    required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe</label>
                                <input type="text" name="tipe_motor" value="{{ old('tipe_motor', $item->tipe_motor) }}"
                                    required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kapasitas (CC)</label>
                                <input type="number" name="cc_motor" value="{{ old('cc_motor', $item->cc_motor) }}" required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Warna Motor</label>
                                <input type="text" name="warna_motor" value="{{ old('warna_motor', $item->warna_motor) }}"
                                    required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Rencana Ambil</label>
                            <input type="date" name="tanggal_rencana_ambil"
                                value="{{ old('tanggal_rencana_ambil', $item->tanggal_rencana_ambil) }}" required
                                class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('admin.penitipan.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none transition-colors">
                        Batalkan
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-bold text-white bg-[#1e40af] rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors shadow-md flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection