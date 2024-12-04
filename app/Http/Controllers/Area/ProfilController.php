<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function index()
    {
        $data['title'] = 'Profil';
        $data['page'] = 'profil';

        return view('area.profil', $data);
    }

    public function edit(Request $request)
    {
        request()->validate([
            'nama' => 'required',
            'username' => 'required|unique:user,username,' . Auth::user()->id . ',id',
            'email' => 'required|email|unique:user,email,' . Auth::user()->id . ',id',
        ]);

        if ($request->has('password') && $request->password != '' && $request->password != null) {
            $data = $request->all();
            $data['password'] = bcrypt(md5($request->password));
        } else {
            $data = $request->except('password');
        }
        try {
            DB::beginTransaction();
            User::where('id', Auth::user()->id)->update($data);
            DB::commit();

            $response['status'] = 1;
            $response['msg'] = 'Berhasil perbarui data';
        } catch (Exception $e) {
            DB::rollBack();

            $response['status'] = 0;
            $response['msg'] = "Gagal perbarui data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
