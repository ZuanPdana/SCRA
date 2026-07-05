@extends('layouts.app')

@section('title', 'Beranda - SCRA')

@section('content')
<section class="rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-cyan-700 text-white p-8 sm:p-12 mb-10">
    <div class="max-w-3xl">
        <p class="uppercase tracking-widest text-blue-100 text-xs mb-3">Smart Classroom Rental Access</p>
        <h1 class="text-3xl sm:text-5xl font-black mb-4">Sistem Reservasi Ruang Kelas Kampus</h1>
        <p class="text-blue-100 text-lg mb-8">Kelola peminjaman ruang kelas dengan alur yang cepat, rapi, dan transparan untuk mahasiswa, dosen, dan admin.</p>
        <div class="flex flex-wrap gap-3">
            @guest
                <a href="{{ route('login') }}" class="bg-white text-blue-700 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk
                </a>
            @else
                <a href="{{ route('classrooms.index') }}" class="bg-white text-blue-700 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50">
                    <i class="fa-solid fa-door-open mr-2"></i>Lihat Ruang Kelas
                </a>
            @endguest
        </div>
    </div>
</section>

<section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
    <article class="bg-white rounded-2xl shadow-sm p-6 border border-blue-50">
        <p class="text-slate-500 text-sm">Total Ruang Kelas</p>
        <p class="text-4xl font-black text-blue-600 mt-2">{{ $classroomsCount }}</p>
    </article>
    <article class="bg-white rounded-2xl shadow-sm p-6 border border-green-50">
        <p class="text-slate-500 text-sm">Tersedia Saat Ini</p>
        <p class="text-4xl font-black text-green-600 mt-2">{{ $availableClassrooms }}</p>
    </article>
    <article class="bg-white rounded-2xl shadow-sm p-6 border border-indigo-50">
        <p class="text-slate-500 text-sm">Alur Reservasi</p>
        <p class="text-4xl font-black text-indigo-600 mt-2">3 Langkah</p>
    </article>
</section>

<section class="bg-white rounded-2xl p-8 shadow-sm">
    <h2 class="text-2xl font-bold mb-6">Cara Kerja</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 rounded-xl bg-blue-50">
            <h3 class="font-semibold mb-2"><i class="fa-solid fa-magnifying-glass mr-2 text-blue-600"></i>Cari Ruang Kelas</h3>
            <p class="text-slate-600 text-sm">Mahasiswa menelusuri ruang berdasarkan lokasi, kapasitas, dan status.</p>
        </div>
        <div class="p-4 rounded-xl bg-blue-50">
            <h3 class="font-semibold mb-2"><i class="fa-solid fa-calendar-check mr-2 text-blue-600"></i>Buat Reservasi</h3>
            <p class="text-slate-600 text-sm">Isi tanggal, jam, serta tujuan penggunaan ruang secara lengkap.</p>
        </div>
        <div class="p-4 rounded-xl bg-blue-50">
            <h3 class="font-semibold mb-2"><i class="fa-solid fa-user-check mr-2 text-blue-600"></i>Validasi Dosen</h3>
            <p class="text-slate-600 text-sm">Dosen memeriksa permintaan lalu menyetujui atau menolak dengan alasan.</p>
        </div>
    </div>
</section>
@endsection
