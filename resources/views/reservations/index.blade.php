@extends('layouts.app')

@section('title', 'Reservasi Saya')

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

<h1 class="text-3xl font-black mb-6">Reservasi Saya</h1>

@if($reservations->isEmpty())
    <div class="bg-white rounded-2xl p-8 shadow-sm text-center text-slate-500">Belum ada reservasi.</div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-100 text-slate-700">
                <tr>
                    <th class="text-left px-4 py-3">Ruang Kelas</th>
                    <th class="text-left px-4 py-3">Tanggal</th>
                    <th class="text-left px-4 py-3">Waktu</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3">{{ $reservation->classroom->room_name }}</td>
                        <td class="px-4 py-3">{{ $reservation->reservation_date->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $reservation->start_time }} - {{ $reservation->end_time }}</td>
                        <td class="px-4 py-3">{{ $statusMap[$reservation->reservation_status] ?? $reservation->reservation_status }}</td>
                        <td class="px-4 py-3"><a href="{{ route('reservations.show', $reservation) }}" class="text-blue-600 font-semibold">Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $reservations->links() }}</div>
@endif
@endsection
