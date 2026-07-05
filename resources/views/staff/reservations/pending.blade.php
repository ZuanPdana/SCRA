@extends('layouts.app')

@section('title', 'Reservasi Menunggu')

@section('content')
<h1 class="text-3xl font-black mb-6">Reservasi Menunggu</h1>

@if($reservations->isEmpty())
    <div class="bg-white rounded-2xl p-8 shadow-sm text-center text-slate-500">Tidak ada reservasi menunggu.</div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="text-left px-4 py-3">Mahasiswa</th>
                    <th class="text-left px-4 py-3">Ruang Kelas</th>
                    <th class="text-left px-4 py-3">Tanggal</th>
                    <th class="text-left px-4 py-3">Waktu</th>
                    <th class="text-left px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3">{{ $reservation->user->name }}</td>
                        <td class="px-4 py-3">{{ $reservation->classroom->room_name }}</td>
                        <td class="px-4 py-3">{{ $reservation->reservation_date->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $reservation->start_time }} - {{ $reservation->end_time }}</td>
                        <td class="px-4 py-3"><a href="{{ route('staff.reservations.show', $reservation) }}" class="text-blue-600 font-semibold">Review</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $reservations->links() }}</div>
@endif
@endsection
