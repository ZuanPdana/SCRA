@extends('layouts.guest')

@section('title', 'Daftar - SCRA')

@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-6"><i class="fa-solid fa-user-plus mr-2 text-blue-600"></i>Daftar</h2>

<form action="{{ route('register') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-blue-500 focus:outline-none" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-blue-500 focus:outline-none" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
        <input type="password" name="password" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-blue-500 focus:outline-none" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-blue-500 focus:outline-none" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP (Opsional)</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Departemen (Opsional)</label>
        <input type="text" name="department" value="{{ old('department') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
    </div>
    <button class="w-full rounded-lg bg-blue-600 text-white py-2.5 font-semibold hover:bg-blue-700">Buat Akun Mahasiswa</button>
</form>
@endsection

@section('footer')
Sudah punya akun? <a class="text-blue-600 font-semibold" href="{{ route('login') }}">Masuk di sini</a>
@endsection
