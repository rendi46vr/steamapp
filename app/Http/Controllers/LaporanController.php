<?php

namespace App\Http\Controllers;

use App\Models\tjual;
use App\Tools\tools;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class LaporanController extends Controller
{
    //
    protected $sess = 'searchLaporan',$sess2 ='searchPerPlat';

    public function index(){

        Session::forget($this->sess);
        $data = [];
        // dd($this->tabletransaksi());
        $data['title']= "Laporan Cuci";
        $data['transaksi'] = $this->tabletransaksi();

        
        return view('laporan.index', $data);
    }
    public  function tabletransaksi($request=[], $ajax = false)
    {
        if(empty($request)){
            $tglMulai ='2023-10-01';
            $tglAkhir = date('Y-m-d');
        }else{
            $tglMulai = $request['first'] ?? date('Y-m-d');
            $tglAkhir = $request['end'] ?? date('Y-m-d');
        }
        // jumlah Kendaraan
        $jumlahKendaraan = tjual::whereBetween('tgl', [$tglMulai, $tglAkhir])
                        ->select('plat')
                        ->groupBy('plat')
                        ->get();
        $totalTransaksiDanPendapatan = tjual::whereBetween('tgl', [$tglMulai, $tglAkhir])
                        ->select(DB::raw('COUNT(*) as totalTransaksi'), DB::raw('SUM(totalbayar) as totalPendapatan'))
                        ->first();
                        
        $jumlahHari = Carbon::parse($tglMulai)->diffInDays(\Carbon\Carbon::parse($tglAkhir)) + 1;
        $totalPendapatan = $totalTransaksiDanPendapatan->totalPendapatan ??0;
        $totalTransaksi = $totalTransaksiDanPendapatan->totalTransaksi ??0 ;
        // Hitung rata-rata transaksi per hari dan pendapatan per hari
        $rataRataTransaksiPerHari =  $totalPendapatan != 0 ? round(($totalTransaksiDanPendapatan->totalTransaksi/ $jumlahHari)) :0;
        $rataRataPendapatanPerHari = $totalPendapatan != 0 ? round($totalPendapatan  / $jumlahHari, 1) :0;
        if($totalTransaksiDanPendapatan){
            $rataRataNilaiTransaksi = $totalPendapatan != 0 ? $totalPendapatan / $totalTransaksi :0;
        }else{
            $rataRataNilaiTransaksi = 0;
        }

        $obj = new stdClass();
        $obj->jumlahKendaraan = $jumlahKendaraan->count();
        $obj->totalTransaksi = ($totalTransaksiDanPendapatan->totalTransaksi ?? 0);
        $obj->totalPendapatan = tools::fRupiah(($totalTransaksiDanPendapatan->totalPendapatan ??0 ));
        $obj->rataRataTransaksiPerHari = $rataRataTransaksiPerHari;
        $obj->rataRataPendapatanPerHari = tools::fRupiah($rataRataPendapatanPerHari);
        $obj->rataRataNilaiTransaksi = tools::fRupiah($rataRataNilaiTransaksi);
        $obj->jenjangWaktu = "$tglMulai s.d $tglAkhir";

        if($ajax){
            $transaksi = $obj;
            return view('laporan.tablelaporan', compact('transaksi'))->render();
        }
        return $obj;
        
        
    }
    public function filterindex(Request $request){
    //    return $request->all();
         $data = $this->tabletransaksi([
            'first' => $request->first,
            'end'   => $request->end,
        ],true);
        return response()->json([
            'parent' =>'.dataTransaksi',
            'data' =>$data 
        ]);
    }

    public function pageperplat($page)
    {
        if (!is_numeric($page)) {
            return $this->tabletperplat(1);
        }
        if (Session::has($this->sess)) {
            return $this->tabletperplat($page, true, true);
        } else {
            return $this->tabletperplat($page,false, true);
        }
    }
    public function searchperplat(Request $request)
    {
        Session::put($this->sess2, $request->all());
        return $this->tabletperplat(1, true, true);
    }

    public function laporanKendaraan()
    {
        Session::forget($this->sess2);
        $transaksi = $this->tabletperplat();
        return view("laporan.perplat", compact("transaksi"))->render();
    }

    public  function tabletperplat($page = 1, $search = false, $ajax = false)
    {
        $transaksi = tjual::select('plat','wa',DB::raw('COUNT(*) as jumlahTransaksi'))->where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess2)['search']);
                $e->where('plat', 'like', '%' . $datasearch . '%')
                    ->orwhere('email', 'like', '%' . $datasearch . '%')
                    ->orwhere('np', 'like', '%' . $datasearch . '%')
                    ->orwhere('wa', 'like', '%' . $datasearch . '%');
            }
        });
        if (session()->has($this->sess2)) {
            // if (session($this->sess2)['first'] && session($this->sess2)['end']) {
            //     $first = session($this->sess2)['first'];
            //     $end = session($this->sess2)['end'];
            //     $transaksi->whereBetween('tgl', [$first, $end]);
            // }
            // if (session($this->sess2)['sip'] != null) {
            //     $transaksi->where('sip', session($this->sess2)['sip']);
            // }
        }
        if (auth()->user()->role != "Admin") {
            $transaksi->where('input_by', auth()->user()->id);
        }
        $transaksi = $transaksi->where("status", "berhasil")
        ->groupby('plat','wa')->orderByDesc('jumlahTransaksi') 
        ->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pageperplat');
        $data = view("laporan.tableperplat", compact("transaksi", "pagination"))->render();
        if($ajax){
            return response()->json([
                "parent" => ".dataTransaksi",
                "data" => $data
            ]);
        }else{
            return $data;
        }
    }

    public function filterLaporanKendaraan($bg){
        Session::forget($this->sess2);
        $transaksi = $this->tableperplatdetail(1, false ,$bg, false);
        $bg = htmlspecialchars($bg);
        return view("laporan.detailplat", compact("transaksi",'bg'))->render();
    }
    public  function tableperplatdetail($page = 1, $search = false, $filter, $ajax = true)
    {
        $transaksi = tjual::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess2)['search']);
                $e->where('plat', 'like', '%' . $datasearch . '%')
                    ->orwhere('email', 'like', '%' . $datasearch . '%')
                    ->orwhere('np', 'like', '%' . $datasearch . '%')
                    ->orwhere('wa', 'like', '%' . $datasearch . '%');
            }
        });

        if (auth()->user()->role != "Admin") {
            $transaksi->where('input_by', auth()->user()->id);
        }
        $transaksi = $transaksi->where("status", "berhasil")->where('plat', htmlspecialchars($filter))
        ->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pagetransaksi');
        $data = view("laporan.tabledetailplat", compact("transaksi", "pagination"))->render();
        if($ajax){
            return response()->json([
                "parent" => ".dataTransaksi",
                "data" => $data
            ]);
        }else{
            return $data;
        }
    }
    
}
