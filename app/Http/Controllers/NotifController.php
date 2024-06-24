<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotifController extends Controller
{
    //


    public function NotifPembayaranDisetujui($id){
        //
        // dari server
        try {
            //code...
        $data = Http::get('http://vittindo.my.id/steamapp/NotifPembayaranDisetujui/'.$id);
        return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        $bayar = Bayar::with('patner')->find($id);
        $noref = $bayar->noref;
        $namaPatner = $bayar->patner->nama_patner;
        $text1 = "Halo $namaPatner,\n\n" .
         "Kami ingin menginformasikan bahwa pembayaran dengan nomor referensi $noref telah disetujui.\n\n" .
         "Terima kasih atas kerjasama Anda.\n\n" .
         "Hormat kami,\n" .
         "Smarwax Palembang";
        $data = Http::post(env('WA_URL') . "kirimpesan", [
            "idclient" => intval(env('WA_IDCLIENT')),
            "number" => $bayar->patner->nowa,
            "pesan" => $text1,
        ]);
    }

    public function NotifPembayaranDitolak($id) {
        try {
            //code...
            $data = Http::get('http://vittindo.my.id/steamapp/NotifPembayaranDitolak/'.$id);
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        $bayar = Bayar::with('patner')->find($id);
        $noref = $bayar->noref;
        $namaPatner = $bayar->patner->nama_patner;
        
        $text1 = "Halo $namaPatner,\n\n" .
                 "Kami ingin menginformasikan bahwa pembayaran dengan nomor referensi $noref telah ditolak.\n\n" .
                 "Silakan hubungi kami untuk informasi lebih lanjut.\n\n" .
                 "Hormat kami,\n" .
                 "Smarwax Palembang";
        
        $data = Http::post(env('WA_URL') . "kirimpesan", [
            "idclient" => intval(env('WA_IDCLIENT')),
            "number" => $bayar->patner->nowa,
            "pesan" => $text1,
        ]);
    }

    public function NotifPengajuanPembayaran($id) {
        try {
            //code...
            $data = Http::get('http://vittindo.my.id/steamapp/NotifPengajuanPembayaran/'.$id);
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        try {
            //code...
            $bayar = Bayar::with('patner')->find($id);
            $noref = $bayar->noref;
            $namaPatner = $bayar->patner->nama_patner;
            $tgl = $bayar->tgl;
            $jumlah = $bayar->jumlah;
            $norek = $bayar->norek;
            $bank = $bayar->bank;
            $atasNama = $bayar->atas_nama;
            $hutangSaatBayar = $bayar->hutang_saat_bayar;

            $buktiPath = storage_path('app/public/' . $bayar->bukti); // Path to the file in storage
            // Get the file extension
            $extension = pathinfo($buktiPath, PATHINFO_EXTENSION);
            $filename = "bukti_pembayaran." . $extension;
        
            $text1 = "Halo SMARTWAX,\n\n" .
                    "Kami ingin menginformasikan bahwa ada pengajuan pembayaran baru dengan detail sebagai berikut:\n\n" .
                    "Nomor Referensi: $noref\n" .
                    "Nama Patner: $namaPatner\n" .
                    "Tanggal Pengajuan: $tgl\n" .
                    "Nominal Bayar: $jumlah\n" .
                    "Nomor Rekening: $norek\n" .
                    "Bank: $bank\n" .
                    "Atas Nama: $atasNama\n" .
                    "Jumlah Hutang Saat Bayar: $hutangSaatBayar\n\n" .
                    "Harap segera ditindaklanjuti.\n\n" .
                    "Hormat kami,\n" .
                    "Sistem Notifikasi SMARTWAX PALEMBANG";
        
            $data = Http::attach('file',file_get_contents($buktiPath), $filename
            )->post(env('WA_URL') . "kirimfile", [
                "idclient" => intval(env('WA_IDCLIENT')),
                "number" => env('WA_SMARTWAX_NUMBER'), // Nomor WhatsApp Smartwax diambil dari environment variables
                "pesan" => $text1,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return true;
    
    }
}
