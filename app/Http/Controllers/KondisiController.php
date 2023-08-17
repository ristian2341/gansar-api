<?php

namespace App\Http\Controllers;

use App\Models\Kondisi;
use Illuminate\Http\Request;


class KondisiController extends Controller
{
    // menampilkan data
    public function index()
    {
        $kondisi = Kondisi::OrderBy("kondisi_id","asc")->get();
        return ['data' => $kondisi];
    }

    public function create(Request $request)
    {
        $kondisi = [];$message = "";
        if(isset($request->kondisi)){
            $kondisi = Kondisi::where(['kondisi_id' => $request->kondisi_id])->first();
            if(!isset($kondisi)){
                $kondisi = new Kondisi();
                $kondisi->kondisi = $request->kondisi;
                $kondisi->save();
                $message = "Input data success";
                $statusCode = 200;
            }else{
                Kondisi::where(['kondisi_id' => $request->kondisi_id])
                    ->update(['kondisi' => $request->kondisi]);
                
                    $kondisi = Kondisi::where(['kondisi' => $request->kondisi])->first();
                    $message = "Update data success";
                    $statusCode = 200;
            }
        }else{
            $statusCode = 500;
            $message = "kondisi tidak boleh kosong";
        }

        return ['kondisi' => $kondisi, 'message' => $message,'statusCode' => $statusCode];
    }

    public function delete($id)
    {
        $kondisi = Kondisi::where("kondisi_id",$id)->delete();
        if(isset($kondisi)){
            $message = "Hapus data Kondisi success";
            $statusCode = 200;
        }else{
            $message = "Hapus data Kondisi gagal";
            $statusCode = 500;
        }
        return ['kondisi' =>[], 'message' => $message,'statusCode' => $statusCode];
    }

    public function search_user($id){
        $message = "";$statusCode = 200;
        $data = Kondisi::where(['kondisi_id' => $id])->first();
       
        if(!isset($data->kondisi)){
            $statusCode = 500;
            $data = [];
            $message = "Kondisi tidak ditemukan";
        }

        return ['data' => $data,'message' => $message,'statusCode' => $statusCode];
    }

}