<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Admin Panel') - ADMIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="min-h-screen bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">
    
    <div class="flex h-screen overflow-hidden">
        
        <div x-show="sidebarOpen" 
             class="fixed inset-0 z-20 transition-opacity bg-black bg-opacity-50 lg:hidden" 
             @click="sidebarOpen = false"
             style="display: none;"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-30 w-64 bg-[#111827] text-gray-300 transition-transform duration-300 lg:static lg:translate-x-0 lg:block shadow-2xl flex flex-col">
            
            <div class="flex items-center justify-center h-16 bg-[#1e40af] border-b border-blue-900 shadow-md">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white tracking-widest uppercase">
                    ADMIN
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white border-l-4 border-[#facc15]' : 'hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3" /></svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.penitipan.index') }}" 
                   class="flex items-center px-4 py-3 rounded-md transition-colors {{ request()->routeIs('admin.penitipan.*') ? 'bg-gray-800 text-white border-l-4 border-[#facc15]' : 'hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span class="font-medium">Data Penitipan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-[#ef4444] rounded-md hover:bg-gray-800 hover:text-red-400 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b shadow-sm z-10">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-4 hover:text-[#1e40af]">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Admin Panel')</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm font-medium text-gray-600 hidden md:block">Petugas Jaga</div>
                    <div class="w-10 h-10 rounded-full bg-[#1e40af] flex items-center justify-center text-white font-bold shadow-inner border-2 border-white ring-2 ring-gray-100">
                        A
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-6 lg:p-8">
                @if(session('success'))
                    <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm" role="alert">
                        <svg class="flex-shrink-0 inline w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        <span class="font-medium">Berhasil!</span>&nbsp;{{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>