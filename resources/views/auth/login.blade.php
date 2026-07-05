@extends('layouts.guest')

@section('title', 'Masuk - SCRA')

@section('content')
<div class="space-y-6">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">
            <i class="fa-solid fa-right-to-bracket mr-2 text-blue-600"></i>Masuk ke Akun Anda
        </h2>
        <p class="text-sm text-gray-600">Sistem Manajemen Reservasi Ruang Kelas</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 transition" 
                required
                placeholder="Masukkan email Anda"
            >
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <input 
                type="password" 
                name="password" 
                class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 transition" 
                required
                placeholder="Masukkan password Anda"
            >
        </div>
        <button class="w-full rounded-lg bg-blue-600 text-white py-3 font-semibold hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg">
            <i class="fa-solid fa-sign-in-alt mr-2"></i>Masuk
        </button>
    </form>
</div>
@endsection

@section('footer')
<p class="text-gray-600">Hubungi administrator untuk membuat akun baru</p>
@endsection
