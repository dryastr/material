<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'Kelola User';
        $data['page'] = 'user';
        $data['user'] = User::latest()->get();
        return view('area.user', $data);
    }

    public function tambah(Request $request)
    {
        request()->validate([
            'nama' => 'required',
            'username' => 'required|unique:user,username',
            'email' => 'required|unique:user,email|email',
            'password' => 'required',
            'role' => 'required',
            'departement' => 'nullable',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt(md5($request->password));

        try {
            User::create($data);

            $response['status'] = '1';
            $response['msg'] = 'Berhasil menambahkan data';
        } catch (Exception $e) {

            $response['status'] = '0';
            $response['msg'] = "Gagal menambahkan data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function edit(Request $request)
    {
        request()->validate([
            'nama' => 'required',
            'username' => 'required|unique:user,username,' . $request->id . ',id',
            'email' => 'required|email|unique:user,email,' . $request->id . ',id',
            'departement' => 'nullable',
            'role' => 'required',
        ]);

        $data = $request->except('password');
        if ($request->has('password') && $request->password != '') {
            $data['password'] = bcrypt(md5($request->password));
        }

        try {
            User::where('id', $request->id)->update($data);

            $response['status'] = '1';
            $response['msg'] = 'Berhasil perbarui data';
        } catch (Exception $e) {

            $response['status'] = '0';
            $response['msg'] = "Gagal perbarui data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function hapus(Request $request)
    {
        try {
            User::where('id', $request->id)->delete();

            $response['status'] = '1';
            $response['msg'] = 'Berhasil menghapus data';
        } catch (Exception $e) {

            $response['status'] = '0';
            $response['msg'] = "Gagal menghapus data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
