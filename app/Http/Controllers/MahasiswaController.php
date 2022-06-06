<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Mahasiswa_Matakuliah;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
    * Display a listing of the resource.
    **
    *@return \Illuminate\Http\Response
    */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);
        
        /*$mahasiswa = $mahasiswa = DB::table('mahasiswa')->paginate(3); // Mengambil semua isi tabel
        $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);
        return view('mahasiswa.index', compact('mahasiswa'));
        with('i', (request()->input('page', 1) - 1) * 5);*/
    }

    public function create()
    {
        
        $kelas = Kelas::all();
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }
    public function store(Request $request)
    {
    //melakukan validasi data
    if ($request->file('Foto')){
        $image_name = $request->file('Foto')->store('image', 'public');
    }
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Email' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required', 
            'Foto' => 'required',
            'Alamat' => 'required',
            'TanggalLahir' => 'required', 
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->foto = $image_name;
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggallahir = $request->get('TanggalLahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
            return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    
    }

    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
            return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));
    }

    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Email' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required', 
            'Foto' => 'required',
            'Alamat' => 'required',
            'TanggalLahir' => 'required', 
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggallahir = $request->get('TanggalLahir');
        if($mahasiswa->foto && file_exists(storage_path('app/public/' . $mahasiswa->foto))){
            Storage::delete('public/' . $mahasiswa->foto);
        }
        $image_name = $request->file('Foto')->store('images', 'public');
        $mahasiswa->foto = $image_name;


        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        
        //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')
                ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    public function destroy( $Nim)
    {
    //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
            return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function search(Request $request){
		$search = $request->search;
		$mahasiswa = DB::table('mahasiswa')
		->where('nama','like',"%".$search."%")->paginate(3);
        return view('mahasiswa.index', compact('mahasiswa'))->with('i', (request()->input('page', 1) - 1) * 5);	
    }
    public function nilai($id){
        $Mahasiswa = Mahasiswa::with('kelas')
            ->where('id_mahasiswa' , $id)->first();
        $matkul = Mahasiswa_Matakuliah::with('matakuliah')
            ->where('mahasiswa_id', $id)->get();
        return view('mahasiswa.nilai', compact('Mahasiswa', 'matkul'));
    }
    public function cetak_pdf($id){
        $mahasiswa = Mahasiswa::with('kelas')
            ->where('id_mahasiswa' , $id)->first();
        $matkul = Mahasiswa_Matakuliah::with('matakuliah')
            ->where('mahasiswa_id', $id)->get();

        $pdf = PDF::loadview('mahasiswa.khs_pdf', ['mahasiswa' => $mahasiswa, 'matkul' => $matkul]);
        return $pdf->stream();
    }
};