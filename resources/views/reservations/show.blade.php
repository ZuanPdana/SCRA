@extends('layouts.app')

@section('title', 'Detail Reservasi')

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

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm p-6">
    <h1 class="text-2xl font-black mb-1">Detail Reservasi #{{ $reservation->id }}</h1>
    <p class="text-slate-500 mb-6">Status: {{ $statusMap[$reservation->reservation_status] ?? $reservation->reservation_status }}</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6">
        <div><span class="text-slate-500">Ruang Kelas:</span> {{ $reservation->classroom->room_name }}</div>
        <div><span class="text-slate-500">Tanggal:</span> {{ $reservation->reservation_date->format('d M Y') }}</div>
        <div><span class="text-slate-500">Waktu:</span> {{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
        <div><span class="text-slate-500">Tujuan:</span> {{ $reservation->purpose }}</div>
    </div>

    @if($reservation->reservation_status === 'Rejected' && $reservation->rejection_reason)
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 mb-6">
            <p class="font-semibold">Alasan penolakan</p>
            <p>{{ $reservation->rejection_reason }}</p>
        </div>
    @endif

    <div class="flex gap-3">
        @if($reservation->reservation_status === 'Pending')
            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Batalkan reservasi ini?')">
                @csrf
                @method('DELETE')
                <button class="rounded-lg bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-700">Batalkan</button>
            </form>
        @endif
        <a href="{{ route('reservations.index') }}" class="rounded-lg bg-slate-200 px-4 py-2 font-semibold">Kembali</a>
    </div>
</div>
@endsection
