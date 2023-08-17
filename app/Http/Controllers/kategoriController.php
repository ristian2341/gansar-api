<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;


class KategoriController extends Controller
{
    // menampilkan data
    public function index()
    {
        $kategori = Kategori::OrderBy("kategori_id","asc")->get();
        return ['data' => $kategori,'statusCode' => 200];
    }

    public function create_kategori(Request $request)
    {
        $kategori = [];$message = "";$statusCode = 200;
        if(isset($request->kategori)){
            $kategori = Kategori::where(['kategori_id' => $request->kategori_id])->first();
            if(!isset($kategori)){
                $kategori = new Kategori();
                $kategori->kategori = $request->kategori;
                $kategori->save();
                $message = "Input data success";
            }else{
                Kategori::where(['kategori_id' => $request->kategori_id])
                    ->update(['kategori' => $request->kategori]);
                
                    $kategori = Kategori::where(['kategori_id' => $request->kategori_id])->first();
                    $message = "Update data success";
            }
        }else{
            $statusCode = 500;
            $message = "Kategori tidak boleh kosong";
        }

        return ['data' => $kategori, 'message' => $message,'statusCode' => $statusCode];
    }

    public function delete($id)
    {
        $kategori = Kategori::where("kategori_id",$id)->delete();
        if($kategori){
            $statusCode = 200;
            $message = "Hapus data kategori success";
        }else{
            $statusCode = 500;
            $message = "Hapus data kategori gagal";
        }
        return ['message' => $message,'statusCode' => $statusCode];
    }

    public function search_user($id){
        $message = "";$statusCode = 200;
        $data = Kategori::where(['kategori_id' => $id])->first();
       
        if(!isset($data->kategori)){
            $statusCode = 500;
            $data = [];
            $message = "Kategori tidak ditemukan";
        }

        return ['data' => $data,'message' => $message,'statusCode' => $statusCode];
    }

}