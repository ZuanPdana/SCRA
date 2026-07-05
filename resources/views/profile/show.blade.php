@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-6">
    <h1 class="text-2xl font-black mb-6">Profil Pengguna</h1>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input type="email" value="{{ $user->email }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 bg-slate-50" readonly>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Departemen</label>
            <input type="text" name="department" value="{{ old('department', $user->department) }}" class="w-full rounded-lg border border-slate-300 px-4 py-2">
        </div>

        <button class="rounded-lg bg-blue-600 text-white px-5 py-2.5 font-semibold hover:bg-blue-700">Simpan Perubahan</button>
    </form>
</div>
@endsection
