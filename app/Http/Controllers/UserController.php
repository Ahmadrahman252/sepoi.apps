<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;

class UserController extends Controller
{
    public function index()
    {
        $umkms = Umkm::select(
            'id',
            'nama',
            'usaha',
            'kelurahan_desa',
            'x',
            'y',
            'kontak',
            'kelas_usaha'
        )
        ->whereNotNull('x')
        ->whereNotNull('y')
        ->where('x', '!=', '')
        ->where('y', '!=', '')
        ->where('x', '!=', 0)
        ->where('y', '!=', 0)
        ->orderBy('nama')
        ->get();

        return view('users.index', compact('umkms'));
    }
}