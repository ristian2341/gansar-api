<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // menampilkan data
    public function index()
    {
        $barang = Barang::OrderBy("id_barang","asc")
            ->select('barang.*','kategori.kategori')
            ->leftJoin('kategori','barang.kategori_id','=','kategori.kategori_id')->get();
        return $barang;
    }

    public function create_barang(Request $request)
    {
        $message = "";
        if(isset($request['deskripsi'])){
            $barang = Barang::where(['id_barang' => $request['id_barang']])->first();
            if(!isset($barang)){
                $barang = new Barang;
                $barang->deskripsi      = $request['deskripsi'];
                // $barang->kondisi_id     = $request['kondisi_id'];
                $barang->jml            = $request['jml'];
                $barang->stok_out       = 0;
                $barang->kategori_id    = $request['kategori_id'];

                $barang->save();
                $message = "Simpan Data success";
            }else{
                Barang::where(['id_barang' => $request['id_barang']])
                    ->update([
                        'deskripsi' => $request->deskripsi,
                        // 'kondisi_id' => $request->kondisi_id,
                        'jml' => $request->jml,
                        'kategori_id' => $request->kategori_id
                    ]);
                $barang = Barang::where(['id_barang' => $request['id_barang']])->first();
                $message = "Update user success";
            }
        }else{
            $barang = [];
            $message = "Deskripsi barang tidak boleh kosong";
        }

        return ['barang' => $barang,'message' => $message];
    }

    public function update_stok(Request $request)
    {
        $message = "";$barang = [];
        if(isset($request['id_barang']))
        {
            $barang = Barang::where(['id_barang' => $request['id_barang']])->first();
            if(isset($barang->id_barang)){
                Barang::where(['id_barang' => $request['id_barang']])
                    ->update([
                        'stok_out' =>  $request->stok_out
                    ]);

                $barang = Barang::where(['id_barang' => $request['id_barang']])->first();
                $message = "Update stok barang success";
            }else{
                $message = "Barang tidak ditemukan";
            }
        }else{
            $message = "id barang tidak boleh kosong";
        }

        return ['barang' => $barang,'message' => $message];
    }

    public function delete($id)
    {
        $barang = Barang::where('id_barang',$id)->delete();
        if($barang){
            $statusCode = 200;
            $message = "Hapus Barang success";
        }else{
            $statusCode = 500;
            $message = "Hapus Barang gagal";
        }

        return ['message' => $message,'statusCode' => $statusCode];
    }

    public function search_data($id){
        $message = "";$statusCode = 200;
        $data = Barang::where(['id_barang' => $id])->first();
       
        if(!isset($data->id_barang)){
            $statusCode = 500;
            $data = [];
            $message = "Barang tidak ditemukan";
        }

        return ['data' => $data,'message' => $message,'statusCode' => $statusCode];
    }

    public function barangready(){
        $message = "";$statusCode = 200;
        $data = Barang::whereRaw('jml-stok_out > 0')->OrderBy("id_barang","asc")->get();
       
        return $data; 
        if(!isset($data->id_barang)){
            $statusCode = 500;
            $data = [];
            $message = "Barang tidak ditemukan";
        }
        return ['data' => $data,'message' => $message,'statusCode' => $statusCode];
    }
}