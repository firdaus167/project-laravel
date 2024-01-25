<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = mahasiswa::orderBy('nim', 'desc')->paginate(2);
        return view('mahasiswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nim' => "required|unique:mahasiswa,nim",
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'jurusan.required' => 'Jurusan harus diisi',
            'nim.required' => 'Nim harus diisi',
            'nim.unique' => 'Nim yang diisikan sudah ada dalam database',
            'nama.required' => 'Nama harus diisi'

        ]);
        $data = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
        ];
        mahasiswa::create($data);
        return redirect('/mahasiswa')->with('success', 'berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = mahasiswa::where('nim',$id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'jurusan.required' => 'Jurusan harus diisi',
            'nama.required' => 'Nama harus diisi'

        ]);
        $data = [
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
        ];
        mahasiswa::where('nim',$id)->update($data);
        return redirect('/mahasiswa')->with('success', 'berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        mahasiswa::where('nim', $id)->delete();
        return redirect('mahasiswa')->with('success', 'Berhasil Hapus data');
    }
}
