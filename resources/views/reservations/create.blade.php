@extends('layouts.app')

@section('title', 'Buat Reservasi')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-6">
    <h1 class="text-2xl font-black mb-2">Reservasi {{ $classroom->room_name }}</h1>
    <p class="text-slate-600 mb-6">Isi detail reservasi ruang kelas.</p>

    <div class="mb-6 rounded-xl border border-blue-100 bg-blue-50 p-4">
        <h2 class="font-semibold text-blue-700 mb-2">Jadwal Sewa Universal (Berlaku Semua Ruang)</h2>
        @if($jadwalSewa->isEmpty())
            <p class="text-sm text-slate-600">Belum ada jadwal sewa universal. Reservasi belum dapat dilakukan.</p>
        @else
            <div class="space-y-1">
                @foreach($jadwalSewa as $jadwal)
                    <p class="text-sm text-slate-600">
                        {{ $jadwal->day_of_week }}: {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->end_time)->format('H:i') }}
                    </p>
                @endforeach
            </div>
        @endif
    </div>

    @if($hariLibur->isNotEmpty())
        <div class="mb-6 rounded-xl border border-rose-100 bg-rose-50 p-4">
            <h2 class="font-semibold text-rose-700 mb-2">Hari Libur</h2>
            <div class="space-y-1">
                @foreach($hariLibur as $libur)
                    <p class="text-sm text-slate-600">
                        {{ $libur->holiday_date->format('d M Y') }} - {{ $libur->title }}
                    </p>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Tanggal Reservasi</label>
                <input type="date" name="reservation_date" value="{{ old('reservation_date') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Jenis Penggunaan</label>
                <select id="purpose_type" name="purpose_type" class="w-full rounded-lg border border-slate-300 px-4 py-2" required>
                    <option value="">Pilih jenis penggunaan</option>
                    <option value="Perkuliahan" @selected(old('purpose_type') === 'Perkuliahan')>Perkuliahan</option>
                    <option value="Kegiatan Lain" @selected(old('purpose_type') === 'Kegiatan Lain')>Kegiatan Lain</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Jam Mulai</label>
                <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Jam Selesai</label>
                <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2" required>
            </div>
        </div>

        <div id="perkuliahan_fields" class="hidden space-y-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
            <h3 class="font-semibold text-blue-700">Detail Perkuliahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Dosen Pengampu</label>
                    <select name="dosen_id" id="dosen_id" class="w-full rounded-lg border border-slate-300 px-4 py-2">
                        <option value="">Pilih dosen</option>
                        @foreach($dosenList as $dosen)
                            <option value="{{ $dosen->id }}" @selected((string) old('dosen_id') === (string) $dosen->id)>{{ $dosen->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Mata Kuliah</label>
                    <input type="text" name="mata_kuliah" id="mata_kuliah" value="{{ old('mata_kuliah') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2" placeholder="Contoh: Algoritma dan Pemrograman">
                </div>
            </div>
        </div>

        <div id="kegiatan_fields" class="hidden space-y-4 rounded-xl border border-amber-100 bg-amber-50 p-4">
            <h3 class="font-semibold text-amber-700">Detail Kegiatan Lain</h3>
            <div>
                <label class="block text-sm font-semibold mb-2">Deskripsi Kegiatan</label>
                <textarea name="kegiatan" id="kegiatan" rows="3" class="w-full rounded-lg border border-slate-300 px-4 py-2" placeholder="Jelaskan kegiatan yang akan dilakukan">{{ old('kegiatan') }}</textarea>
                <p class="text-xs text-amber-700 mt-2">Kegiatan lain hanya bisa disetujui oleh admin.</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Tujuan/Nama Kegiatan</label>
            <input type="text" name="purpose" value="{{ old('purpose') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2" placeholder="Opsional - isi singkat tujuan reservasi">
        </div>

        <button class="rounded-lg bg-blue-600 text-white px-5 py-2.5 font-semibold hover:bg-blue-700">Kirim Reservasi</button>
    </form>
</div>

<script>
    const purposeType = document.getElementById('purpose_type');
    const perkuliahanFields = document.getElementById('perkuliahan_fields');
    const kegiatanFields = document.getElementById('kegiatan_fields');

    const dosenInput = document.getElementById('dosen_id');
    const mataKuliahInput = document.getElementById('mata_kuliah');
    const kegiatanInput = document.getElementById('kegiatan');

    function togglePurposeFields() {
        const selected = purposeType.value;

        perkuliahanFields.classList.toggle('hidden', selected !== 'Perkuliahan');
        kegiatanFields.classList.toggle('hidden', selected !== 'Kegiatan Lain');

        if (dosenInput) dosenInput.required = selected === 'Perkuliahan';
        if (mataKuliahInput) mataKuliahInput.required = selected === 'Perkuliahan';
        if (kegiatanInput) kegiatanInput.required = selected === 'Kegiatan Lain';
    }

    purposeType.addEventListener('change', togglePurposeFields);
    togglePurposeFields();
</script>
@endsection
