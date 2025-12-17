@extends('base')
@section('title', 'Tambah Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')

@section('content')
<section class="p-4 bg-white rounded-lg min-h-[50vh]">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-[#C0392B] mb-6">Tambah Pegawai Baru</h1>

        <form action="{{ route('pegawai.store') }}" method="POST">
            @csrf
            
            {{-- Nama --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500" required>
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Pekerjaan (Dropdown) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                <select name="pekerjaan_id" class="w-full rounded-md border-gray-300 shadow-sm border p-2 bg-white" required>
                    <option value="">-- Pilih Pekerjaan --</option>
                    @foreach($pekerjaan as $p)
                        <option value="{{ $p->id }}" {{ old('pekerjaan_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
                @error('pekerjaan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Gender (Radio) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                <div class="flex gap-4 mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} class="text-blue-600" required>
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="text-pink-600">
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status (Checkbox) --}}
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Status Pegawai Aktif</span>
                </label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
                <a href="{{ route('pegawai.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
            </div>
        </form>
    </div>
</section>
@endsection