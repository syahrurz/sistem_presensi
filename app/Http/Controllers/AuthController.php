<?php

namespace App\Http\Controllers;

use App\Models\User; // Menggunakan model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        // Menggunakan Auth default Laravel untuk tabel 'users'
        if(Auth::attempt(['nik' => $request->nik, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'Nik / Password Salah']);
        }
    }

    public function proseslogout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda berhasil logout');
    }
}
