<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Buku;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return view ('Buku');

        $response = Http::get('http://localhost:8080/buku');


        if ($response->successful()) {
            $buku = collect($response->json())->sortBy('id')->values();

            return view('Buku', compact('buku'));
        } else {
            return back()->with('error', 'Gagal ambil data');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //kalo ada 2 ya tulis 2
        //$respon_kelas = Http:: get('http://localhost:8080/Mahasiswa'); misal
        //kelas = collect ($respon_kelas->json())->sortBy('id_kelas)->values();

        //$respon_kelas = Http:: get('http://localhost:8080/Mahasiswa'); misal
        //kelas = collect ($respon_kelas->json())->sortBy('id_kelas)->values();

        return view('tambahbuku');
        //return view('tambahMahasiswa',
        //['kelas' => $kelas,
        //'prodi' => $prodi]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validate = $request->validate([
                'id' => 'required',
                'judul_buku' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required'

            ]);

            Http::post('http://localhost:8080/buku', $validate);

            response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan!',
                'data' => $request
            ], 201);

            return redirect()->route('Buku.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //
        $response = Http::get("http://localhost:8080/buku/$id");

    if ($response->successful()) {
        $buku = $response->json();
        return view('editBuku', compact('buku'));
    } else {
        return redirect()->route('Buku.index')->with('error', 'Data tidak ditemukan');
    }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $buku)
    {
        //
         try {
            $validate = $request->validate([
               'id' => 'required',
                'judul_buku' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required'


            ]);

            Http::put("http://localhost:8080/buku/$buku", $validate);

            response()->json([
                'success' => true,
                'message' => 'Mahasiswa berhasil ditambahkan!',
                'data' => $request
            ], 201);

            return redirect()->route('Buku.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $buku)
    {
        //
        Http::delete("http://localhost:8080/buku/$buku");
        return redirect()->route('Buku.index');
    }
}
