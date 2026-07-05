@extends('layouts.app')

@section('title', 'Jadwal Mata Kuliah')

@section('content')
<div class="bg-white rounded-2xl shadow-sm p-6">
    <h1 class="text-2xl font-black mb-2">Jadwal Mata Kuliah</h1>
    <p class="text-slate-600 mb-6">Jadwal ini digunakan sebagai informasi kegiatan perkuliahan di setiap ruang.</p>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-slate-200 rounded-xl overflow-hidden">
            <thead class="bg-slate-100 text-slate-700 text-sm">
                <tr>
                    <th class="text-left px-4 py-3">Hari</th>
                    <th class="text-left px-4 py-3">Ruang Kelas</th>
                    <th class="text-left px-4 py-3">Mata Kuliah</th>
                    <th class="text-left px-4 py-3">Dosen</th>
                    <th class="text-left px-4 py-3">Jam</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($jadwalMataKuliah as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">{{ $item->day_of_week }}</td>
                        <td class="px-4 py-3">{{ $item->classroom->room_name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->mata_kuliah }}</td>
                        <td class="px-4 py-3">{{ $item->dosen->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500">Belum ada jadwal mata kuliah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
