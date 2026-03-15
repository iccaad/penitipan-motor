<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Isi Data Penitipan - MDMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 py-8 lg:py-12">

    <div class="container max-w-2xl mx-auto p-4 sm:p-6 lg:p-0">

        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Form Registrasi Titip</h1>
            <p class="text-sm text-gray-500 mt-2">Pastikan data sesuai dengan kartu identitas dan STNK.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl flex items-center shadow-sm">
                <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-[#1e40af] px-6 py-4">
                <h2 class="text-white font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Input Data Baru
                </h2>
            </div>

            <form action="{{ route('penitipan.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8 space-y-8">
                @csrf

                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Identitas
                        Pemilik</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap Sesuai KTP <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_penitip" value="{{ old('nama_penitip') }}"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white"
                                placeholder="Cth: Budi Santoso" />
                            @error('nama_penitip') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Handphone (Aktif)
                                    <span class="text-red-500">*</span></label>
                                <input type="tel" name="no_hp" value="{{ old('no_hp') }}"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white"
                                    placeholder="08xxxxxxxxxx" />
                                @error('no_hp') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Kependudukan
                                    (NIK)</label>
                                <input type="number" name="no_ktp" value="{{ old('no_ktp') }}"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white"
                                    placeholder="16 Digit NIK" />
                                @error('no_ktp') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Spesifikasi
                        Kendaraan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Polisi (Plat) <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nomor_polisi" value="{{ old('nomor_polisi') }}"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white uppercase font-bold text-lg text-center tracking-widest"
                                placeholder="H 1234 AB" />
                            @error('nomor_polisi') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Merk <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="merk_motor" value="{{ old('merk_motor') }}"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white"
                                    placeholder="Cth: Honda" />
                                @error('merk_motor') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Motor <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tipe_motor" value="{{ old('tipe_motor') }}"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white"
                                    placeholder="Cth: Beat CBS" />
                                @error('tipe_motor') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kapasitas (CC) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="cc_motor" value="{{ old('cc_motor') }}"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white"
                                    placeholder="110" />
                                @error('cc_motor') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Warna Dominan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="warna_motor" value="{{ old('warna_motor') }}"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-gray-50 focus:bg-white"
                                    placeholder="Hitam" />
                                @error('warna_motor') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}
                                </p> @enderror
                            </div>
                        </div>

                        <div class="pt-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Fisik Kendaraan <span
                                    class="text-red-500">*</span></label>
                            <div class="flex items-center justify-center w-full">
                                <label for="foto_motor"
                                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors relative overflow-hidden group">

                                    <div id="upload-prompt"
                                        class="flex flex-col items-center justify-center pt-5 pb-6 transition-opacity">
                                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-500"><span class="font-semibold text-[#1e40af]">Klik
                                                untuk unggah</span> atau ambil gambar</p>
                                    </div>

                                    <img id="image-preview" src="#" alt="Preview"
                                        class="hidden absolute inset-0 w-full h-full object-cover z-0" />

                                    <div id="change-overlay"
                                        class="hidden absolute inset-0 bg-black/50 flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-semibold">Ganti Foto</span>
                                    </div>

                                    <input id="foto_motor" type="file" name="foto_motor" class="hidden" accept="image/*"
                                        onchange="previewImage(event)" />
                                </label>
                            </div>
                            @error('foto_motor') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Jadwal
                        Penitipan</h3>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Mulai Titip <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_titip" value="{{ old('tanggal_titip') }}"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-white" />
                            @error('tanggal_titip') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Rencana Diambil <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_rencana_ambil" value="{{ old('tanggal_rencana_ambil') }}"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1e40af] outline-none transition-all bg-white" />
                            @error('tanggal_rencana_ambil') <p class="text-red-500 text-xs mt-1 font-medium">
                            {{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-gray-900 bg-[#facc15] hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all transform hover:-translate-y-1">
                        Kirim Form Penitipan
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                    <p class="text-xs text-center text-gray-400 mt-4">Dengan menekan tombol di atas, Anda menyetujui
                        syarat & ketentuan penitipan kendaraan yang berlaku.</p>
                </div>
            </form>
        </div>
    </div>
    <script>
    function previewImage(event) {
        const input = event.target;
        const prompt = document.getElementById('upload-prompt');
        const preview = document.getElementById('image-preview');
        const overlay = document.getElementById('change-overlay');

        if (input.files && input.files[0]) {
            // Membuat URL sementara dari file yang dipilih di perangkat user
            const fileUrl = URL.createObjectURL(input.files[0]);
            
            // Set sumber gambar
            preview.src = fileUrl;
            
            // Ubah visibilitas elemen
            prompt.classList.add('hidden');       // Sembunyikan ikon kamera + teks
            preview.classList.remove('hidden');   // Tampilkan gambar
            overlay.classList.remove('hidden');   // Aktifkan overlay hitam saat di-hover
        }
    }
</script>
</body>

</html>