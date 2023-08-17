<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /// menampilkan seluruh data user //
    public function index()
    {
        $user = User::OrderBy("id_user","asc")->get();
        return response()->json([
            'message' => 'success',
            'data' => $user,
        ]);
    }

    public function create_user(Request $request)
    {
        $message = "";$statusCode = 200;
        if(isset($request['user_name'])){
            $user = User::where(['user_name' => $request['user_name']])->orWhere(['id_user' => $request['id_user']])->first();
            if(!isset($user)){
                $pass = ($request['password'] != '') ?  $request['password'] : '1234';
                $user = new User;
                $user->nama             = $request['nama'];
                $user->jabatan          = $request['jabatan'];
                $user->user_name        = $request['user_name'];
                $user->password         = md5($pass);
                $user->wa               = $request['wa'];
                $user->administrator    = $request['administrator'];

                $user->save();
                $message = "Simpan Data success";
            }else{
                $success = User::where(['id_user' => $request['id_user']])
                    ->update([
                        "nama"          => $request['nama'],
                        "jabatan"       => $request['jabatan'],
                        "user_name"     => $request['user_name'],
                        "wa"            => $request['wa'],
                        "administrator" => $request['administrator'],
                    ]);
              
                if(($request['password'] != '') && $success){
                    $success = User::where(['id_user' => $request['id_user']])
                    ->update([
                        "password" => md5($request['password']),
                    ]);
                }
                $message = "Update user success";
            }
        }else{
            $statusCode = 500;
            $user = [];
            $message = "User Name Tidak Boleh kosong";
        }
    
        return ['user' => $user,'message' => $message,'statusCode' => $statusCode];
    }

    public function login(Request $request)
    {
        $message = "";  $statusCode = 200;
        $user = User::where(['user_name' => $request['user_name']])->first();
        
        if(!isset($user)){
            $statusCode = 500;
            $user = [];
            $message = "User name tidak ditemukan";
        }else{
            $message = "User Ditemukan";
        }

        return ['users' => $user,'message' => $message,'statusCode' => $statusCode];
    }

    public function search_user($id)
    {
        $message = "";$statusCode = 200;
        $user = User::where(['id_user' => $id])->first();
       
        if(!isset($user->nama)){
            $statusCode = 500;
            $user = [];
            $message = "User name tidak ditemukan";
        }

        return ['users' => $user,'message' => $message,'statusCode' => $statusCode];
    }

    public function delete($id)
    {
        $message = "";$statusCode = 200;$success = true;
        $success = User::where(['id_user' => $id])->delete();
       
        if($success){
            $message = "Hapus data success";
        }else{
            $statusCode = 500;
            $message = "Hapus data gagal";
        }
        return ['message' => $message,'statusCode' => $statusCode];
    }
}
