<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SCRA - Sistem Reservasi Ruang Kelas')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-600 to-blue-800">
    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-600 mb-2">
                    <i class="fa-solid fa-building mr-2"></i>SCRA
                </h1>
                <p class="text-gray-600">Sistem Reservasi Ruang Kelas</p>
            </div>

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold mb-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>Validasi gagal</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    <i class="fa-solid fa-circle-check mr-1"></i>{{ session('success') }}
                </div>
            @endif

            @yield('content')

            <div class="mt-6 text-center text-sm text-gray-600">
                @yield('footer')
            </div>
        </div>
    </div>
</body>
</html>
