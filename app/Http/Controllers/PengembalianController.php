<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use App\Models\Pinjam;
use App\Models\PinjamDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    // menampilkan data
    public function index()
    {
        $pengembalian = Pengembalian::OrderBy("id_pengembalian","asc")
        ->join('users','pengembalian.id_user','=','users.id_user')
        ->select('pengembalian.*','users.nama')->get();
        return $pengembalian;
    }

    public function create(Request $request)
    {
        $message = "";$success = true;$statusCode = 200;
      
        $pengembalian = Pengembalian::where(['nomor' => $request['nomor']])->first();
        if(!isset($pengembalian)){
            $nomor_pinjam = Pengembalian::where(['nomor_pinjam' => $request['nomor_pinjam']])->where('status', '<>', 0)->first();
            if(!isset($nomor_pinjam)){
                $pengembalian = new Pengembalian();
                $pengembalian->nomor	      = PengembalianController::code();
                $pengembalian->nomor_pinjam	  = $request['nomor_pinjam'];
                $pengembalian->tanggal        = date('Y-m-d',strtotime($request['tanggal']));
                $pengembalian->id_user        = $request['id_user'];
                $pengembalian->keterangan     = $request['keterangan'];
                $pengembalian->status         = 1;
    
                if(!$pengembalian->save()){
                    $success = false;
                }
    
                if($success){
                    $detail = json_decode($request['detail']);    
                    foreach ($detail as $data) {
                        $det_pengembalian = new PengembalianDetail();
                        $det_pengembalian->nomor = $pengembalian->nomor;
                        $det_pengembalian->nomor_pinjam = $pengembalian->nomor_pinjam;
                        $det_pengembalian->id_barang = $data->id_barang;
                        $det_pengembalian->jml = $data->qty;
                        $det_pengembalian->save();
                    }
                    $message = "Simpan Data success";
                }
    
                if($success){
                    $message = "Simpan Data success";
                }
            }else{
                $statusCode = 500;
                $message = "Nomor Pinjam Sudah ada";
            }
            
        }elseif(isset($pengembalian)){
            $success = Pengembalian::where(['nomor' => $request['nomor']])
                ->update([
                    "id_user"        => $request['id_user'],
                    "tanggal"        => date('Y-m-d',strtotime($request['tanggal'])),
                    "keterangan"     => $request['keterangan'],
                ]);

            if($success){
                PengembalianDetail::where('nomor',$request['nomor'])->delete();
                $detail = json_decode($request['detail']);    
                foreach ($detail as $data) {
                    $det_pengembalian = new PengembalianDetail();
                    $det_pengembalian->nomor = $pengembalian->nomor;
                    $det_pengembalian->nomor_pinjam = $pengembalian->nomor_pinjam;
                    $det_pengembalian->id_barang = $data->id_barang;
                    $det_pengembalian->jml = $data->qty;
                    $det_pengembalian->save();
                }
                $message = "Simpan Data success";
            }

            if($success){
                $pengembalian = Pengembalian::where(['nomor' => $request['nomor']])->first();
                $message = "Update user success";
            }else{
                $message = "ada yang error";
            }
        }

        return ['pengembalian' => $pengembalian,'message' => $message,'statusCode' => $statusCode];
    }

    public function update_stok($id_barang)
    {
        $kembali = PengembalianDetail::where(['id_barang' => $id_barang])->andWhere->sum('jml');
        $pinjam = PinjamDetail::where(['id_barang' => $id_barang])->sum('jml');
        $barang = Barang::where(['id_barang' => $id_barang])->first();
        $stok_out = $pinjam - $kembali;
       
        $barang = Barang::where(['id_barang' => $id_barang])
            ->update(['stok_out' => $stok_out]);
        return $barang;
    }

    public function delete($id)
    {
        $statusCode = 200;
        $pengembalian = Pengembalian::where(['nomor' => $id])
        ->update([
            "status" => 0,
        ]);

        if($pengembalian){
            $message = "Hapus Pengembalian success";
        }else{
            $statusCode = 500;
            $message = "Hapus Pengembalian Gagal";
        }
    
        return ['message' => $message,'statusCode' => $statusCode];
    }
    
    public function BarangPinjam($id)
    {
       
        $statusCode = 200;
        $barang_pinjam = DB::table('pinjam_detail')
            ->select('pinjam_detail.*','barang.deskripsi')
            ->join('barang','pinjam_detail.id_barang','=','barang.id_barang')
            ->where('nomor_pinjam','=',$id)->get();
        if(empty($barang_pinjam)){
            $statusCode = 500;
            $message = "Data Pinjam yang masih ada kosong";
        }
        return ['statusCode' => $statusCode,'data'  => $barang_pinjam];
    }

    public function pinjam_data()
    {
        $statusCode = 200;
        $message = "data kosong";
      
        //$pinjam = Pinjam::whereNotIn("nomor_pinjam", DB::table('pengembalian')->select('nomor_pinjam')->where('status', '<>', 0)->get()->toArray())
        $pinjam = Pinjam::whereNotIn("nomor_pinjam",function($query){
            $query->select('nomor_pinjam')->from('pengembalian')->where('status','=','2');})->where('status','=','2')
            ->get();
        if(empty($pinjam)){
            $statusCode = 500;
            $message = "data kosong";
        }
        return ['data' => $pinjam,'statusCode' => $statusCode,'message' => $message];
    }

    public function code()
    {
        $sNo = 'PENG-'.date('Ym')."-";
        $nomor = 1;
       
        $pengembalian  = Pengembalian::where('nomor', 'like', $sNo . '%')->OrderBy("nomor","desc")->first();
      
        if(isset($pengembalian)){
            $nomor = substr($pengembalian->nomor,strlen($pengembalian->nomor)-4,4) + 1;
        }
       
        return (string)$sNo.sprintf("%04d",$nomor);
    }

    public function search_data($id){
        $message = "";$statusCode = 200;
        $data = Pengembalian::where(['nomor' => $id])->join('users','pengembalian.id_user','=','users.id_user')
        ->select('pengembalian.*','users.nama')->first();
        $detail = PengembalianDetail::where(['nomor' => $id])
            ->join('barang','pengembalian_detail.id_barang','=','barang.id_barang')
            ->select('pengembalian_detail.*','barang.deskripsi')->get();
       
        if(!isset($data->nomor_pinjam)){
            $statusCode = 500;
            $data = [];
            $detail = [];
            $message = "Barang tidak ditemukan";
        }

        return ['data' => $data,'detail' => $detail,'message' => $message,'statusCode' => $statusCode];
    }
    
    public function approve_kembali($id){
        $message = "";$statusCode = 200;
        $kembali = Pengembalian::where(['nomor' => $id])
            ->update(['status' => 2]);
       
        if(!$kembali){
            $message = "Gagal Approve Pengembalian";
            $statusCode = 500;
        }else{
            $det_pinjam = PengembalianDetail::where(['nomor' => $id])->get();
            foreach ($det_pinjam as $key => $value) {
                $this->update_stok($value->id_barang);
            }
            $message = "Apporove Pengembalian sukses";
        }

        return ['pengembalian' => $kembali,'message' => $message,'statusCode' => $statusCode];
    }
}