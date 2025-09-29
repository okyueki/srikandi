@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Laporan Ranap Per Dokter')

@section('content')
<div class="p-6 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Ranap Per Dokter</h2>
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex flex-col sm:w-60">
                <label class="text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="datetime-local" name="start" value="{{ $startDate }}" 
                       class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>
            <div class="flex flex-col sm:w-60">
                <label class="text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="datetime-local" name="end" value="{{ $endDate }}" 
                       class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No. Rawat</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No. RM</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Pasien</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Cara Bayar</th> <!-- BARU -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Ruangan</th>     <!-- BARU -->
                        @for($i = 1; $i <= 7; $i++)
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Dokter {{ $i }}</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tindakan {{ $i }}</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Biaya {{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($pivot && count($pivot) > 0)
                        @foreach($pivot as $row)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row['no_rawat'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $row['no_rkm_medis'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $row['nm_pasien'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium bg-blue-50 rounded">{{ $row['cara_bayar'] }}</td> <!-- BARU -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium bg-green-50 rounded">{{ $row['ruangan'] }}</td>   <!-- BARU -->
                                @for($i = 1; $i <= 7; $i++)
                                    <td class="px-4 py-4 text-sm text-gray-700 text-center">
                                        <span class="inline-block px-2 py-1 rounded-md bg-blue-50 text-blue-800 font-medium">
                                            {{ $row["dokter$i"] ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $row["tindakan$i"] ?? '—' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 text-right font-medium">
                                        {{ number_format($row["biaya$i"] ?? 0, 0, ',', '.') }}
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="24" class="px-6 py-12 text-center text-gray-500"> <!-- Perhatikan colspan jadi 24 -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.497-.885-6.172-2.366M19 14v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2M5 7h14" />
                                </svg>
                                <p class="text-lg font-medium">Tidak ada data ditemukan</p>
                                <p class="text-sm text-gray-400 mt-1">Coba ubah rentang tanggal atau periksa kembali filter.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection