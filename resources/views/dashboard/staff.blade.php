@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black">Dashboard Dosen</h1>
    <p class="text-slate-600">Validasi permintaan reservasi ruang kelas mahasiswa.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-slate-500">Menunggu</p>
        <p class="text-3xl font-black text-amber-600 mt-1">{{ $pendingReservations }}</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-slate-500">Disetujui</p>
        <p class="text-3xl font-black text-green-600 mt-1">{{ $approvedReservations }}</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <p class="text-sm text-slate-500">Ditolak</p>
        <p class="text-3xl font-black text-red-600 mt-1">{{ $rejectedReservations }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl p-6 shadow-sm">
    <h2 class="font-bold text-xl mb-4">Permintaan Menunggu Terbaru</h2>
    @if($recentPending->isEmpty())
        <p class="text-slate-500">Tidak ada reservasi menunggu.</p>
    @else
        <div class="space-y-3">
            @foreach($recentPending as $res)
                <div class="rounded-xl border border-slate-100 p-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">{{ $res->classroom->room_name }} - {{ $res->user->name }}</p>
                        <p class="text-sm text-slate-500">{{ $res->reservation_date->format('d M Y') }} | {{ $res->start_time }} - {{ $res->end_time }}</p>
                    </div>
                    <a href="{{ route('staff.reservations.show', $res) }}" class="text-blue-600 font-semibold">Review</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
