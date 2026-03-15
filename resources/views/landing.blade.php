<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sistem Penitipan Motor Berbasis Web - Polrestabes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-[#111827] min-h-screen flex items-center justify-center relative overflow-hidden text-gray-800">
    
    <div class="absolute inset-0 z-0 opacity-20">
        <div class="absolute inset-0 bg-[radial-gradient(#1e40af_1px,transparent_1px)] [background-size:20px_20px]"></div>
    </div>

    <div class="container max-w-lg mx-auto p-6 z-10">
        <div class="bg-white p-10 rounded-2xl shadow-2xl border-t-8 border-[#1e40af] text-center transform transition-all hover:scale-[1.01]">
            
            <div class="mx-auto w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mb-6 shadow-inner ring-4 ring-[#1e40af]/10">
                <svg class="w-12 h-12 text-[#1e40af]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">E-Penitipan Motor</h1>
            <p class="text-sm font-bold text-[#1e40af] uppercase tracking-widest mb-6">Polrestabes Semarang</p>
            
            <p class="text-gray-600 mb-8 leading-relaxed">
                Layanan pencatatan dan dokumentasi penitipan kendaraan roda dua terintegrasi digital demi keamanan dan kenyamanan Anda.
            </p>

            <div class="flex flex-col space-y-3">
                <a href="{{ route('penitipan.form') }}" class="w-full flex justify-center items-center bg-[#facc15] hover:bg-yellow-500 text-yellow-900 font-bold px-6 py-4 rounded-xl shadow-lg transition-all focus:ring-4 focus:ring-yellow-300">
                    Mulai Form Penitipan
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <span class="text-xs text-gray-400 mt-4 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Data Anda dilindungi enkripsi sistem
                </span>
            </div>
        </div>
    </div>
</body>
</html>