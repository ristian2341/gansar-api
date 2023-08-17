<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\LapBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LapBarangController extends Controller
{
    // menampilkan data
    public function index()
    {
        $laporan = LapBarang::OrderBy("nomor","desc")
        ->join('barang','laporan_barang.id_barang','=','barang.id_barang')
        ->select('laporan_barang.*','barang.deskripsi as barang')->get();
        return $laporan;
    }

    public function create(Request $request)
    {
        $message = "";$success = true;$statusCode = 200;
      
        $LapBarang = LapBarang::where(['nomor' => $request['nomor']])->first();
        if(!isset($LapBarang)){
            //SIMPAN DATA
            if(!isset($nomor_pinjam)){
                $LapBarang = new LapBarang();
                $LapBarang->nomor	        = $this->code();
                $LapBarang->tanggal         = date('Y-m-d',strtotime($request['tanggal']));
                $LapBarang->id_barang       = $request['id_barang'];
                $LapBarang->jml             = $request['jml'];
                $LapBarang->keterangan      = $request['keterangan'];
                $LapBarang->kondisi         = $request['kondisi'];
                $LapBarang->status          = 1;
    
                if(!$LapBarang->save()){
                    $success = false;
                }else{
                    $message = "Simpan Data success";
                }
            }else{
                $statusCode = 500;
                $message = "Nomor Pinjam Sudah ada";
            }
            
        }elseif(isset($LapBarang)){
            $success = LapBarang::where(['nomor' => $request['nomor']])
                ->update([
                    "tanggal"       => date('Y-m-d',strtotime($request['tanggal'])),
                    "keterangan"    => $request['keterangan'],
                    "id_barang"     => $request['id_barang'],
                    "jml"           => $request['jml'],
                    "keterangan"    => $request['keterangan'],
                    "kondisi"       => $request['kondisi'],
                ]);

            if($success){
                $LapBarang = LapBarang::where(['nomor' => $request['nomor']])->first();
                $message = "Update Laporan Success";
            }else{
                $statusCode = 500;
                $message = "ada yang error";
            }
        }

        return ['LapBarang' => $LapBarang,'message' => $message,'statusCode' => $statusCode];
    }

    public function update_stok($id_barang,$stok_out)
    {
        $jml = LapBarang::where(['id_barang' => $id_barang,'status' => 2])->sum('jml');
        $jml = $stok_out + $jml;
        $barang = Barang::where(['id_barang' => $id_barang])
            ->update([
                'stok_out' => $jml
            ]);
        return $barang;
    }

    public function delete($id)
    {
        $statusCode = 200;$message = "";
        $update_lap = LapBarang::where('nomor',$id)->update([
            'status' =>  0,
        ]);
        if(!$update_lap){
            $statusCode = 500;
            $message = "Hapus LapBarang gagal";
        }else{
            $message = "Hapus Laporan success";
        }
        return ['message' => $message,'statusCode' => $statusCode];
    }
    
    public function code()
    {
        $sNo = 'LAP-'.date('Ym')."-";
        $nomor = 1;
       
        $LapBarang  = LapBarang::where('nomor', 'like', $sNo . '%')->OrderBy("nomor","desc")->first();
      
        if(isset($LapBarang)){
            $nomor = substr($LapBarang->nomor,strlen($LapBarang->nomor)-4,4) + 1;
        }
       
        return (string)$sNo.sprintf("%04d",$nomor);
    }

    public function search_data($id){
        $message = "Ditemukan";$statusCode = 200;
        $data = LapBarang::where(['nomor' => $id])->join('barang','laporan_barang.id_barang','=','barang.id_barang')
        ->select('laporan_barang.*','barang.deskripsi')->first();
        
        if(!isset($data->nomor)){
            $statusCode = 500;
            $data = [];
            $message = "Barang tidak ditemukan";
        }

        return ['data' => $data,'message' => $message,'statusCode' => $statusCode];
    }
    
    public function approve($id){
        $message = "";$statusCode = 200;
        $LapBarang = LapBarang::where(['nomor' => $id])
            ->update(['status' => 2]);
        if(!$LapBarang){
            $message = "Gagal Approve Laporan";
            $statusCode = 500;
        }else{
            $LapBarang = LapBarang::where(['nomor' => $id])->first();
            $barang = Barang::where('id_barang',$LapBarang->id_barang)->first();
            $this->update_stok($barang->id_barang,$barang->stok_out);
            $message = "Apporove Laporan sukses";
        }

        return ['LapBarang' => $LapBarang,'message' => $message,'statusCode' => $statusCode];
    }
}