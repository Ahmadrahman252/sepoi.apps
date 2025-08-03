<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use Excel;


class UmkmController extends Controller
{
    public function showForm()
    {
        return view('umkm.import');
    }
   
public function kategori()
{
    // Query yang dioptimalkan untuk mengambil data UMKM dengan koordinat valid
    $umkms = Umkm::select(
        'id',
        'nama',
        'usaha',
        'kelurahan_desa',
        'x',
        'y',
        'kontak',
        'kelas_usaha',
        'resiko_sdm',
        'risiko_pemodalan',
        'risiko_produksi',
        'risiko_pemasaran',
        'risiko_hukum'
    )
    ->whereNotNull('x')
    ->whereNotNull('y')
    ->where('x', '!=', '')
    ->where('y', '!=', '')
    ->where('x', '!=', 0)
    ->where('y', '!=', 0)
    ->orderBy('nama')
    ->get();
    return view('users.kategori', compact('umkms'));
}

    public function importExcel(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $data = \Excel::load($file->getRealPath())->get();

            foreach ($data as $row) {
                Umkm::create([
                    'nama' => $row['nama_pemilik'],
                    'usaha' => $row['usaha'],
                    'kelurahan_desa' => $row['kelurahan_desa'],
                    'x' => $row['x'],
                    'y' => $row['y'],
                    'kontak'=> $row ['kontak'],
                    'kelas_usaha' => $row ['kelas_usaha'],
                    'resiko_sdm' => $row['resiko_sdm'],
                    'risiko_pemodalan' => $row['risiko_pemodalan'],
                    'risiko_produksi' => $row['risiko_produksi'],
                    'risiko_pemasaran' => $row['risiko_pemasaran'],
                    'risiko_hukum' => $row['risiko_hukum'],
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor!');
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    public function peta()
    {
        $umkms = Umkm::all(); 
        return view('users.detail', compact('umkms'));
    }

    //ini detailnya
    public function detail($id)
    {
        $umkm = Umkm::findOrFail($id);
        return view('umkm.detail', compact('umkm'));
    }

    public function getUmkmData()
    {
        $umkms = Umkm::select('id', 'nama_pemilik', 'usaha', 'kelurahan_desa', 'x', 'y')
                    ->whereNotNull('x')
                    ->whereNotNull('y')
                    ->get();
        
        return response()->json($umkms);
    }
    public function showMap()
{
    $spots = Umkm::select(
        'id',
        'nama as name',
        'usaha as info',
        'kelurahan_desa',
        'x as lat',
        'y as lng',
        'kontak',
        'kelas_usaha'
    )
    ->whereNotNull('x')
    ->whereNotNull('y')
    ->get();

    return view('users.index', compact('spots'));
}



    
}