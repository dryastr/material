<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth(Request $req)
    {
        $credentials = $req->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $remember = false;
        if (request()->has('remember') && request('remember') === 'on') {
            $remember = true;
        }

        $credentials['username'] = htmlspecialchars($credentials['username'], ENT_QUOTES, 'UTF-8');
        $credentials['password'] = htmlspecialchars($credentials['password'], ENT_QUOTES, 'UTF-8');

        $password = md5($credentials['password']);
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $password], $remember)) {
            $req->session()->regenerate();
            $response['status'] = '1';
            $response['msg'] = 'Loggin berhasil';
            $response['url'] = url('dashboard');
        } else {
            $response['status'] = '0';
            $response['msg'] = 'Periksa username dan password';
        }

        return response()->json($response);
    }
    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect()->route('login');
    }
}
