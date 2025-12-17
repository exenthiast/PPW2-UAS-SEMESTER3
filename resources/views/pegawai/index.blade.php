@extends('base')
@section('title', 'Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')

@section('content')
<section class="p-4 bg-white rounded-lg min-h-[50vh]">
    <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Daftar Pegawai</h1>
    
    <div class="mx-auto max-w-screen-xl">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                <span class="font-medium">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('pegawai.create') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                Tambah Pegawai
            </a>
            
            <form class="flex w-full max-w-sm gap-2" action="{{ route('pegawai.index') }}" method="GET">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari nama atau email..." class="w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-x divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700" width="1">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Pekerjaan</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Gender</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700" width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($data as $d)
                    <tr class="hover:bg-gray-50">
                        {{-- Nomor Urut Pagination --}}
                        <td class="px-4 py-3">{{ $data->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $d->email }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $d->pekerjaan ? $d->pekerjaan->nama : '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($d->gender == 'male')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Laki-laki</span>
                            @else
                                <span class="bg-pink-100 text-pink-800 text-xs font-medium px-2.5 py-0.5 rounded">Perempuan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($d->is_active)
                                <span class="text-green-600 font-bold">Aktif</span>
                            @else
                                <span class="text-gray-400">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <a href="{{ route('pegawai.edit', $d->id) }}" class="rounded-l-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50">
                                    Edit
                                </a>
                                <form action="{{ route('pegawai.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-r-md border border-l-0 border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Data pegawai belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Link --}}
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    </div>
</section>
@endsection