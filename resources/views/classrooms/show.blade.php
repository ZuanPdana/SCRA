@extends('layouts.app')

@section('title', 'Detail Ruang Kelas')

@section('content')
<div class="mb-4">
    <a href="{{ route('classrooms.index') }}" class="text-blue-600 hover:text-blue-700"><i class="fa-solid fa-arrow-left mr-1"></i>Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <section class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
        <h1 class="text-3xl font-black mb-4">{{ $classroom->room_name }}</h1>
        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
            <div><span class="text-slate-500">Kode:</span> {{ $classroom->room_code }}</div>
            <div><span class="text-slate-500">Kapasitas:</span> {{ $classroom->capacity }}</div>
            <div><span class="text-slate-500">Lokasi:</span> {{ $classroom->location }}</div>
            <div><span class="text-slate-500">Status:</span> {{ $classroom->status }}</div>
        </div>
        <p class="text-slate-600 mb-2"><strong>Fasilitas:</strong> {{ $classroom->facilities ?: '-' }}</p>
        <p class="text-slate-600"><strong>Deskripsi:</strong> {{ $classroom->description ?: '-' }}</p>

        <hr class="my-6">
        <h2 class="text-xl font-bold mb-3">Jadwal Sewa (Berlaku Semua Ruang)</h2>
        @if($jadwalSewa->isEmpty())
            <p class="text-slate-500 mb-6">Belum ada jadwal sewa untuk ruang ini.</p>
        @else
            <div class="space-y-2 mb-6">
                @foreach($jadwalSewa as $jadwal)
                    <div class="p-3 rounded-lg border border-blue-200 bg-blue-50">
                        <p class="font-semibold">{{ $jadwal->day_of_week }}</p>
                        <p class="text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->end_time)->format('H:i') }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        <hr class="my-6">
        <h2 class="text-xl font-bold mb-3">Hari Libur</h2>
        @if($hariLibur->isEmpty())
            <p class="text-slate-500 mb-6">Belum ada hari libur terdaftar untuk ruang ini.</p>
        @else
            <div class="space-y-2 mb-6">
                @foreach($hariLibur as $libur)
                    <div class="p-3 rounded-lg border border-rose-200 bg-rose-50">
                        <p class="font-semibold">{{ $libur->holiday_date->format('d M Y') }} - {{ $libur->title }}</p>
                        <p class="text-sm text-slate-600">{{ $libur->description ?: 'Hari libur.' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <hr class="my-6">
        <h2 class="text-xl font-bold mb-3">Jadwal Aktif</h2>
        @if($reservations->isEmpty())
            <p class="text-slate-500">Belum ada jadwal reservasi aktif.</p>
        @else
            <div class="space-y-2">
                @foreach($reservations as $res)
                    <div class="p-3 rounded-lg border border-amber-200 bg-amber-50">
                        <p class="font-semibold">{{ $res->reservation_date->format('d M Y') }}</p>
                        <p class="text-sm text-slate-600">{{ $res->start_time }} - {{ $res->end_time }} | {{ $res->purpose }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <aside class="bg-white rounded-2xl shadow-sm p-6 h-fit">
        @if($classroom->status === 'Available' && auth()->check() && auth()->user()->isMahasiswa())
            <a href="{{ route('reservations.create', $classroom) }}" class="block text-center rounded-lg bg-blue-600 text-white py-3 font-semibold hover:bg-blue-700">Reservasi Sekarang</a>
        @else
            <p class="text-sm text-slate-500">Reservasi hanya untuk akun mahasiswa pada ruang yang tersedia.</p>
        @endif
    </aside>
</div>
@endsection
