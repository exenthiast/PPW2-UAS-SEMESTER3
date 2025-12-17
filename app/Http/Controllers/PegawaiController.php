<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    // READ - Menampilkan daftar pegawai
    public function index(Request $request) {
        $keyword = $request->get('keyword');

        // Mengambil data pegawai + data pekerjaan terkait (Eager Loading)
        $data = Pegawai::with('pekerjaan')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->paginate(5); // Pagination Task 15

        $data->appends(['keyword' => $keyword]);

        return view('pegawai.index', compact('data'));
    }

    // CREATE - Menampilkan form tambah
    public function create() {
        // Kita butuh data pekerjaan untuk dropdown
        $pekerjaan = Pekerjaan::all(); 
        return view('pegawai.create', compact('pekerjaan'));
    }

    // STORE - Menyimpan data baru
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email', // Email harus unik
            'gender' => 'required|in:male,female',
            'pekerjaan_id' => 'required|exists:pekerjaan,id', // Harus ada di tabel pekerjaan
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $pegawai = new Pegawai();
        $pegawai->nama = $request->nama;
        $pegawai->email = $request->email;
        $pegawai->gender = $request->gender;
        $pegawai->pekerjaan_id = $request->pekerjaan_id;
        $pegawai->is_active = $request->has('is_active') ? 1 : 0; // Checkbox handling

        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    // EDIT - Menampilkan form edit
    public function edit($id) {
        $pegawai = Pegawai::findOrFail($id);
        $pekerjaan = Pekerjaan::all(); // Untuk dropdown
        return view('pegawai.edit', compact('pegawai', 'pekerjaan'));
    }

    // UPDATE - Menyimpan perubahan
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email,'.$id, // Unik kecuali punya sendiri
            'gender' => 'required|in:male,female',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->nama = $request->nama;
        $pegawai->email = $request->email;
        $pegawai->gender = $request->gender;
        $pegawai->pekerjaan_id = $request->pekerjaan_id;
        $pegawai->is_active = $request->has('is_active') ? 1 : 0;

        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui');
    }

    // DELETE - Menghapus data (Soft Delete)
    public function destroy($id) {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus');
    }
}