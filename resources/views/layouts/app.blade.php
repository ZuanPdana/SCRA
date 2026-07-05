<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SCRA - Sistem Reservasi Ruang Kelas')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800">
    <nav class="bg-white shadow-sm border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-blue-600">
                    <i class="fa-solid fa-building mr-2"></i>SCRA
                </a>

                <div class="flex items-center gap-3 sm:gap-5 text-sm sm:text-base">
                    @auth
                        <a href="{{ route('classrooms.index') }}" class="text-slate-600 hover:text-blue-600">
                            <i class="fa-solid fa-door-open mr-1"></i>Ruang Kelas
                        </a>
                        <a href="{{ route('schedules.jadwal-sewa') }}" class="text-slate-600 hover:text-blue-600">
                            <i class="fa-solid fa-clock mr-1"></i>Jadwal Sewa
                        </a>
                        <a href="{{ route('schedules.jadwal-mata-kuliah') }}" class="text-slate-600 hover:text-blue-600">
                            <i class="fa-solid fa-book-open mr-1"></i>Jadwal Mata Kuliah
                        </a>

                        @if(auth()->user()->isMahasiswa())
                            <a href="{{ route('reservations.index') }}" class="text-slate-600 hover:text-blue-600">
                                <i class="fa-solid fa-calendar-days mr-1"></i>Reservasi Saya
                            </a>
                        @endif

                        @if(auth()->user()->isDosen())
                            <a href="{{ route('staff.dashboard') }}" class="text-slate-600 hover:text-blue-600">
                                <i class="fa-solid fa-user-check mr-1"></i>Dosen
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="text-slate-600 hover:text-blue-600">
                                <i class="fa-solid fa-gear mr-1"></i>Admin
                            </a>
                        @endif

                        <div class="relative group">
                            <button class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                                <i class="fa-solid fa-user text-blue-600"></i>
                                <span class="text-slate-700 font-medium">{{ auth()->user()->name }}</span>
                            </button>
                            <div class="hidden group-hover:block absolute right-0 top-full mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 z-50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                                    <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.show') }}" class="block px-6 py-3 text-slate-700 hover:bg-blue-50 border-b border-slate-100 transition">
                                    <i class="fa-solid fa-user-edit mr-2 text-blue-600"></i>Edit Profil
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-6 py-3 text-slate-700 hover:bg-red-50 transition text-red-600 font-medium">
                                        <i class="fa-solid fa-sign-out-alt mr-2"></i>Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-700 hover:text-blue-600">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <p class="font-semibold mb-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>Ada kesalahan</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                <i class="fa-solid fa-circle-check mr-1"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
