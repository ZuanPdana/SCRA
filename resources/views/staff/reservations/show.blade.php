@extends('layouts.app')

@section('title', 'Review Reservasi')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm p-6">
    <h1 class="text-2xl font-black mb-6">Review Reservasi #{{ $reservation->id }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6">
        <div><span class="text-slate-500">Mahasiswa:</span> {{ $reservation->user->name }}</div>
        <div><span class="text-slate-500">Email:</span> {{ $reservation->user->email }}</div>
        <div><span class="text-slate-500">Ruang Kelas:</span> {{ $reservation->classroom->room_name }}</div>
        <div><span class="text-slate-500">Tanggal:</span> {{ $reservation->reservation_date->format('d M Y') }}</div>
        <div><span class="text-slate-500">Waktu:</span> {{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
        <div><span class="text-slate-500">Tujuan:</span> {{ $reservation->purpose }}</div>
    </div>

    <div class="flex flex-col md:flex-row gap-3">
        <form action="{{ route('staff.reservations.approve', $reservation) }}" method="POST" class="flex-1">
            @csrf
            @method('PUT')
            <button class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-white font-semibold hover:bg-green-700">Setujui</button>
        </form>

        <form action="{{ route('staff.reservations.reject', $reservation) }}" method="POST" class="flex-1 space-y-2">
            @csrf
            @method('PUT')
            <textarea name="rejection_reason" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2" placeholder="Alasan penolakan" required></textarea>
            <button class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-white font-semibold hover:bg-red-700">Tolak</button>
        </form>
    </div>
</div>
@endsection
