<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pengembalian;
use App\Models\Pinjam;
use App\Models\PinjamDetail;
use Illuminate\Http\Request;


class PinjamController extends Controller
{
    // menampilkan data
    public function index()
    {
        $pinjam = Pinjam::OrderBy("id_Pinjam","asc")
            ->join('users','pinjam.id_user','=','users.id_user')
            ->select('pinjam.*','users.nama')->get();
        return $pinjam;
    }

    public function create(Request $request)
    {
        $message = "";$success = true; $statusCode = 200;
        
        $pinjam = Pinjam::where(['nomor_pinjam' => $request['nomor_pinjam']])->first();
        if(!isset($pinjam)){
            $pinjam = new Pinjam;
            $pinjam->nomor_pinjam   = PinjamController::code();
            $pinjam->tanggal        = date('Y-m-d',strtotime($request['tanggal']));
            $pinjam->tgl_kembali    = date('Y-m-d',strtotime($request['tgl_kembali']));
            $pinjam->id_user        = $request['id_user'];
            $pinjam->keterangan     = $request['keterangan'];
            $pinjam->status         = 1;

            if(!$pinjam->save()){
                $success = false;
                $statusCode = 500;
            }

            if($success){
                $detail = json_decode($request['detail']);    
                foreach ($detail as $data) {
                    $det_pinjam = new PinjamDetail();
                    $det_pinjam->nomor_pinjam = $pinjam->nomor_pinjam;
                    $det_pinjam->id_barang = $data->id_barang;
                    $det_pinjam->jml = $data->qty;
                    $det_pinjam->save();
                }
                $message = "Simpan Data success";
            }

        }else{
            $pengembalian = Pengembalian::where(['nomor_pinjam' => $request->nomor_pinjam])->first();
            if(!isset($pengembalian)){
                $success = Pinjam::where(['nomor_pinjam' => $request['nomor_pinjam']])
                ->update([
                    "tanggal"       => date('Y-m-d',strtotime($request['tanggal'])),
                    "tgl_kembali"   => date('Y-m-d',strtotime($request['tgl_kembali'])),
                    "id_user"       => $request['id_user'],
                    "keterangan"    => $request['keterangan'],
                ]);
            }else{
                $success = false;
                $statusCode = 500;
                $message = "Nomor Pinjaman Sudah dibuatkan pengembalian";
            }
            
            if($success){
                PinjamDetail::where('nomor_pinjam',$request['nomor_pinjam'])->delete();
                $detail = json_decode($request['detail']);    
                foreach ($detail as $data) {
                    $det_pinjam = new PinjamDetail();
                    $det_pinjam->nomor_pinjam = $pinjam->nomor_pinjam;
                    $det_pinjam->id_barang = $data->id_barang;
                    $det_pinjam->jml = $data->qty;
                    $det_pinjam->save();
                }
                $message = "Updated Data success";
            }
           
            $pinjam = Pinjam::where(['nomor_pinjam' => $request['nomor_pinjam']])->first();
            
        }
        
        return ['pinjam' => $pinjam,'message' => $message,'statusCode' => $statusCode];
    }

    public function update_stok($id_barang)
    {
        $success = true;
        $jml = PinjamDetail::where(['id_barang' => $id_barang])
            ->whereNotIn('nomor_pinjam',Pengembalian::select('nomor_pinjam')->where('status','=',2)->get()->toArray())->sum('jml');
        
        $barang = Barang::where(['id_barang' => $id_barang])
            ->update([
                'stok_out' => $jml
            ]);
        if(!$barang){
            $success = false;
        }
        return $success;
    }

    public function approve_pinjam($id){
        $message = "";$statusCode = 200;
        $det_pinjam = PinjamDetail::where(['nomor_pinjam' => $id])->get();
            foreach ($det_pinjam as $key => $value) {
                if($statusCode == 200){
                    $up_stok = $this->update_stok($value->id_barang);
                    if(!$up_stok){
                        $statusCode = 500;
                    }
                }else{
                    $statusCode = 500;
                }
            }
        if($statusCode == 200){
            $pinjam = Pinjam::where(['nomor_pinjam' => $id])
            ->update(['status' => 2]);
            if(!$pinjam){
                $message = "Gagal Approve Peminjaman";
                $statusCode = 500;
            }else{
                $message = "Apporove peminjaman sukses";
            }
        }else{
            $message = "Gagal Update Stok";
        }
        

        return ['pinjam' => $pinjam,'message' => $message,'statusCode' => $statusCode];
    }

    public function search_data($id){
        $message = "";$statusCode = 200;
        $data = Pinjam::where(['nomor_pinjam' => $id])->join('users','pinjam.id_user','=','users.id_user')
        ->select('pinjam.*','users.nama')->first();
        $detail = PinjamDetail::where(['nomor_pinjam' => $id])
            ->join('barang','pinjam_detail.id_barang','=','barang.id_barang')
            ->select('pinjam_detail.*','barang.deskripsi')->get();
       
        if(!isset($data->nomor_pinjam)){
            $statusCode = 500;
            $data = [];
            $detail = [];
            $message = "Barang tidak ditemukan";
        }

        return ['data' => $data,'detail' => $detail,'message' => $message,'statusCode' => $statusCode];
    }

    public function delete($id)
    {
        $statusCode = 200;
        $pinjam = Pinjam::where(['nomor_pinjam' => $id])
            ->update([
                "status" => 0,
            ]);
        if($pinjam){
            $statusCode = 200;
            $message = "Hapus pinjam success";
        }else{
            $statusCode = 500;
            $message = "Hapus pinjam gagal";
        }

        return ['message' => $message,'statusCode' => $statusCode];
    }

    public function code()
    {
        $sNo = 'PIN-'.date('Ym')."-";
        $nomor = 1;
       
        $pinjam  = Pinjam::where('nomor_pinjam', 'like', $sNo.'%')->orderBy("nomor_pinjam","desc")->first();
        
        if(isset($pinjam)){
            $nomor = substr($pinjam->nomor_pinjam,strlen($pinjam->nomor_pinjam)-4,4) + 1;
        }
       
        return (string)$sNo.sprintf("%04d",$nomor);
    }
}