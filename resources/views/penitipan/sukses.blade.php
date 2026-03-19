<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Bukti Penitipan Motor - {{ $data->kode_penitipan }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white !important;
            }

            .print-shadow-none {
                box-shadow: none !important;
                border-color: black !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center py-10">
    <div class="container max-w-md mx-auto p-4 sm:p-6 lg:p-0">

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden print-shadow-none relative">

            <div
                class="hidden sm:block absolute top-[140px] -left-4 w-8 h-8 bg-gray-100 rounded-full border-r border-gray-200 no-print">
            </div>
            <div
                class="hidden sm:block absolute top-[140px] -right-4 w-8 h-8 bg-gray-100 rounded-full border-l border-gray-200 no-print">
            </div>

            <div class="bg-[#1e40af] px-8 py-6 text-center text-white">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-full mb-3 shadow-md">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-bold tracking-wide uppercase">Penitipan Berhasil</h1>
                <p class="text-blue-200 text-sm mt-1">Sistem MDMS Polrestabes</p>
            </div>

            <div class="px-8 py-6 text-center border-b-2 border-dashed border-gray-200 bg-gray-50">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">KODE REGISTRASI</p>
                <div class="text-3xl font-black text-gray-900 tracking-tighter">{{ $data->kode_penitipan }}</div>
                <div class="mt-3 flex justify-center h-8 space-x-1 opacity-50">
                    <div class="w-1 bg-gray-800"></div>
                    <div class="w-2 bg-gray-800"></div>
                    <div class="w-1 bg-gray-800"></div>
                    <div class="w-3 bg-gray-800"></div>
                    <div class="w-1 bg-gray-800"></div>
                    <div class="w-2 bg-gray-800"></div>
                    <div class="w-2 bg-gray-800"></div>
                    <div class="w-1 bg-gray-800"></div>
                    <div class="w-3 bg-gray-800"></div>
                    <div class="w-1 bg-gray-800"></div>
                    <div class="w-2 bg-gray-800"></div>
                </div>
            </div>

            <div class="p-8 space-y-5">
                <div class="flex justify-between items-end border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Nomor Polisi</span>
                    <span class="text-lg font-bold text-gray-900 uppercase">{{ $data->nomor_polisi }}</span>
                </div>

                <div class="flex justify-between items-end border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Nama Pemilik</span>
                    <span class="text-base font-bold text-gray-800 text-right">{{ $data->nama_penitip }}</span>
                </div>

                <div class="flex justify-between items-end border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Tanggal Masuk</span>
                    <span
                        class="text-sm font-bold text-gray-800 text-right">{{ \Carbon\Carbon::parse($data->tanggal_titip)->format('d M Y') }}</span>
                </div>

                <div class="flex justify-between items-end border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Batas Ambil</span>
                    <span
                        class="text-sm font-bold text-red-600 text-right">{{ \Carbon\Carbon::parse($data->tanggal_rencana_ambil)->format('d M Y') }}</span>
                </div>

                <div class="flex justify-between items-end border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Lokasi Pengambilan</span>
                    <span class="text-sm font-bold text-[#1e40af] text-right">
                        {{ $data->lokasi_jenis === 'polsek'
                        ? 'Polsek ' . str_replace('Polsek ', '', $data->lokasi_nama)
                        : 'Polrestabes Semarang' }}
                    </span>
                </div>

                <div class="px-1 pb-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                        <p class="text-sm font-bold text-red-500 mb-1">PERHATIAN</p>
                        <p class="text-xs text-yellow-800 list-disc list-inside space-y-1">Untuk pengambilan <strong>wajib</strong>:</p>
                        <ul class="text-xs text-yellow-700 list-disc list-inside space-y-1 mt-3">
                            <li>menunjukkan bukti penitipan ini</li>
                            <li>menunjukkan Kartu Identitas (KTP)</li>
                            <li>menunjukkan bukti kepemilikan kendaraan (STNK/BPKB)</li>
                        </ul>
                    </div>
                </div>

                <div class="text-center text-xs text-gray-400 mt-1">
                    Dicetak pada {{ now()->format('d M Y H:i') }}
                </div>
                <hr class="border-dashed border-gray-200 my-3">
                <p class="text-xs text-center text-gray-400 mt-4 leading-tight">
                    Simpan bukti digital ini dengan baik. Wajib ditunjukkan kepada petugas saat pengambilan kendaraan.
                </p>
            </div>
        </div>

        <div class="mt-6 space-y-3 no-print">
            <button onclick="window.print()"
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Cetak / Simpan PDF
            </button>
            <a href="{{ route('penitipan.form') }}"
                class="w-full flex justify-center items-center py-3 px-4 rounded-xl text-sm font-bold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                Kembali ke Halaman Utama
            </a>
        </div>

    </div>
</body>

</html>