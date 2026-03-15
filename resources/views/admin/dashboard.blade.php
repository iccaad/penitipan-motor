@extends('admin.layout')

@section('title', 'Dashboard Operasional')

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Data</p>
                <p class="text-3xl font-bold text-[#1e40af] mt-1">{{ $total ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-[#1e40af]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Masih Dititip</p>
                <p class="text-3xl font-bold text-[#facc15] mt-1">{{ $sedang ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Sudah Diambil</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $sudah ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-red-100 flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-2 bg-[#ef4444]"></div>
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Terlambat</p>
                <p class="text-3xl font-bold text-[#ef4444] mt-1">{{ $terlambat ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#ef4444]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">Aktivitas Penitipan Terbaru</h2>
                <a href="{{ route('admin.penitipan.index') }}" class="text-sm font-medium text-[#1e40af] hover:text-blue-800 hover:underline flex items-center">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th scope="col" class="px-6 py-3">Kode / Plat</th>
                            <th scope="col" class="px-6 py-3">Nama Pemilik</th>
                            <th scope="col" class="px-6 py-3">Tanggal Masuk</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPenitipan as $item)
                            <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-[#1e40af]">{{ $item->kode_penitipan }}</span>
                                        <span class="text-xs text-gray-500">{{ $item->nomor_polisi }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $item->nama_penitip }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_titip)->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4">
                                    @if($item->status == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <span class="w-2 h-2 mr-1.5 bg-yellow-500 rounded-full"></span>
                                            Dititip
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-2 h-2 mr-1.5 bg-green-500 rounded-full"></span>
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="mt-2 text-sm font-medium">Belum ada data operasional.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Distribusi Status</h2>
            </div>
            <div class="p-6 flex-1 flex items-center justify-center">
                <div class="w-full max-w-[250px] aspect-square relative">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const url = "{{ route('admin.statistik') }}";

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('statusChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut', // Doughnut terlihat lebih modern daripada Pie
                        data: {
                            labels: ['Dititip', 'Selesai', 'Terlambat'],
                            datasets: [{
                                data: [data.sedang_dititip || 0, data.sudah_diambil || 0, data.terlambat_diambil || 0],
                                backgroundColor: ['#facc15', '#10B981', '#ef4444'], // Sesuaikan dengan warna taktis
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%', // Membuat lubang di tengah agar terlihat modern
                            plugins: { 
                                legend: { 
                                    position: 'bottom',
                                    labels: { usePointStyle: true, padding: 20 }
                                } 
                            }
                        }
                    });
                })
                .catch(err => console.error('Gagal mengambil data statistik', err));
        });
    </script>
@endpush