@extends('layouts.app')

@section('title', 'Ruang Kelas')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-black mb-4">Ruang Kelas</h1>
    <form action="{{ route('classrooms.index') }}" method="GET" class="bg-white rounded-2xl p-5 shadow-sm grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama ruang..." class="rounded-lg border border-slate-300 px-4 py-2">
        <input type="number" name="capacity" value="{{ $capacity }}" placeholder="Kapasitas minimum" class="rounded-lg border border-slate-300 px-4 py-2">
        <select name="status" class="rounded-lg border border-slate-300 px-4 py-2">
            <option value="">Semua Status</option>
            <option value="Available" {{ $status === 'Available' ? 'selected' : '' }}>Tersedia</option>
            <option value="Unavailable" {{ $status === 'Unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
            <option value="Maintenance" {{ $status === 'Maintenance' ? 'selected' : '' }}>Perawatan</option>
        </select>
        <button class="rounded-lg bg-blue-600 text-white px-4 py-2 font-semibold hover:bg-blue-700">Filter</button>
    </form>
</div>

@if($classrooms->isEmpty())
    <div class="bg-white rounded-2xl p-8 shadow-sm text-center text-slate-500">Ruang kelas tidak ditemukan.</div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($classrooms as $classroom)
            <article class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-24 flex items-center justify-center text-4xl text-white">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <div class="p-5">
                    <h2 class="font-bold text-lg">{{ $classroom->room_name }}</h2>
                    <p class="text-sm text-slate-500 mb-3">{{ $classroom->location }}</p>
                    <p class="text-sm">Kode: <span class="font-semibold">{{ $classroom->room_code }}</span></p>
                    <p class="text-sm">Kapasitas: <span class="font-semibold">{{ $classroom->capacity }}</span></p>
                    <p class="text-sm mb-4">Status:
                        @if($classroom->status === 'Available')
                            <span class="inline-flex rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs">Tersedia</span>
                        @elseif($classroom->status === 'Maintenance')
                            <span class="inline-flex rounded-full bg-amber-100 text-amber-700 px-2 py-0.5 text-xs">Perawatan</span>
                        @else
                            <span class="inline-flex rounded-full bg-red-100 text-red-700 px-2 py-0.5 text-xs">Tidak Tersedia</span>
                        @endif
                    </p>
                    <div class="mb-4 rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <p class="text-xs font-semibold text-slate-700 mb-2">Jadwal Sewa (Berlaku Semua Ruang)</p>
                        @if($jadwalSewa->isEmpty())
                            <p class="text-xs text-slate-500">Belum ada jadwal sewa.</p>
                        @else
                            <div class="space-y-1">
                                @foreach($jadwalSewa as $jadwal)
                                    <p class="text-xs text-slate-600">
                                        {{ $jadwal->day_of_week }}: {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->end_time)->format('H:i') }}
                                    </p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('classrooms.show', $classroom) }}" class="block text-center rounded-lg bg-blue-600 text-white py-2 font-semibold hover:bg-blue-700">Detail Ruang</a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-6">{{ $classrooms->links() }}</div>
@endif
@endsection
