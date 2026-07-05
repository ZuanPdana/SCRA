@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
@php
$statusMap = [
    'Pending' => 'Menunggu',
    'Approved' => 'Disetujui',
    'Rejected' => 'Ditolak',
    'Cancelled' => 'Dibatalkan',
    'Completed' => 'Selesai',
];
@endphp

<div class="mb-8">
    <h1 class="text-3xl font-black">Halo, {{ auth()->user()->name }}</h1>
    <p class="text-slate-600">Dashboard Mahasiswa untuk pengelolaan reservasi.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-slate-500">Total Reservasi</p>
        <p class="text-3xl font-black text-blue-600 mt-1">{{ $totalReservations }}</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-slate-500">Status Terakhir</p>
        <p class="text-2xl font-black text-amber-600 mt-1">{{ $latestReservation ? ($statusMap[$latestReservation->reservation_status] ?? $latestReservation->reservation_status) : '-' }}</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-slate-500">Ruang Tersedia</p>
        <p class="text-3xl font-black text-green-600 mt-1">{{ $availableClassrooms }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl p-6 shadow-sm">
    <h2 class="font-bold text-xl mb-4">Riwayat Reservasi Terbaru</h2>
    @if($reservationHistory->isEmpty())
        <p class="text-slate-500">Belum ada reservasi.</p>
    @else
        <div class="space-y-3">
            @foreach($reservationHistory as $res)
                <div class="rounded-xl border border-slate-100 p-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">{{ $res->classroom->room_name }}</p>
                        <p class="text-sm text-slate-500">{{ $res->reservation_date->format('d M Y') }} | {{ $res->start_time }} - {{ $res->end_time }}</p>
                    </div>
                    <a href="{{ route('reservations.show', $res) }}" class="text-blue-600 font-semibold">Detail</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
