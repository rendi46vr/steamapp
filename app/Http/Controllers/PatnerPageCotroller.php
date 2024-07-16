<?php

namespace App\Http\Controllers;

use App\Models\Patner;
use App\Models\tiket;
use App\Models\tjual;
use App\Tools\tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PatnerPageCotroller extends Controller
{
    //
    protected $sess = 'searcPatnertransaksi';

    public function index(){
        $data = [];
        $data['data'] =  tiket::all();
        $data['user'] = auth()->user()->patner;
        $data['title'] =  $data['user']->nama_patner." -  Smartwax Palembang";
        return view('patner-page.mydashboard', $data);
    }

    public function transaksi()
    {
        Session::forget($this->sess);
        $data =[];
        $data['transaksi'] = $this->tabletransaksi();
        if(Session::has('PatnerID')){
            $data['user'] = Patner::find(Session::get('PatnerID'));
        }else{
            $data['user'] = auth()->user()->patner;
        }
        return view("transaksi.patner.transaksi", $data)->render();
    }


    public  function tabletransaksi($page = 1, $search = false)
    {
        $transaksi = tjual::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('plat', 'like', '%' . $datasearch . '%')
                    ->orwhere('wa', 'like', '%' . $datasearch . '%');
            }
        });
        if (session()->has($this->sess)) {
            if (session($this->sess)['first'] && session($this->sess)['end']) {
                $first = session($this->sess)['first'];
                $end = session($this->sess)['end'];
                $transaksi->whereBetween('tgl', [$first, $end]);
            }
        } else {
            $transaksi->whereBetween('tgl', [date("Y-m-01"), date("Y-m-d")]);
        }
        if(Session::has('PatnerID')){
            $patnerID = Session::get('PatnerID');
        }else{
            $patnerID=auth()->user()->patner_id;
        }

        $cut = $transaksi;
        $hutang = $cut->where('patner_id', $patnerID)->where("status", "berhasil")->sum("totalbayar");
        $transaksi = $transaksi->where('patner_id', $patnerID)->where("status", "berhasil")->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        // return $transaksi;
        // dd( $transaksi );
       
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pagepatnertransaksi');
        return view("transaksi.patner.tabletransaksi", compact("transaksi", "pagination", "hutang"))->render();
    }

    public function pagetransaksi($page)
    {
        if (!is_numeric($page)) {
            return $this->tabletransaksi(1);
        }
        if (Session::has($this->sess)) {
            return $this->tabletransaksi($page, true);
        } else {
            return $this->tabletransaksi($page);
        }
    }
    public function searchtransaksi(Request $request)
    {
        Session::put($this->sess, $request->all());
        return $this->tabletransaksi(1, true);
    }

    //order
    public function torder()
    {
        Session::forget($this->sess);
        $transaksi = $this->tabletorder();
        return view("transaksi.patner.torder", compact("transaksi"))->render();
    }


    public  function tabletorder($page = 1, $search = false)
    {
        $transaksi =
            tjual::where(function ($e) use ($search) {
                if ($search) {
                    $datasearch =  htmlspecialchars(session($this->sess)['search']);
                    $e->where('plat', 'like', '%' . $datasearch . '%')
                        ->orwhere('np', 'like', '%' . $datasearch . '%')
                        ->orwhere('wa', 'like', '%' . $datasearch . '%');
                }
            });
        if (session()->has($this->sess)) {
            if (session($this->sess)['first'] && session($this->sess)['end']) {
                $first = session($this->sess)['first'];
                $end = session($this->sess)['end'];
                $transaksi->whereBetween('tgl', [$first, $end]);
            }
        }
        $transaksi = $transaksi->where(["status"=> "pending", "patner_id" => auth()->user()->patner_id])->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pending = true;
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pagepatnerorder');
        return view("transaksi.patner.tabletorder", compact("transaksi", "pagination", "pending"))->render();
    }

    public function pagetorder($page)
    {
        if (!is_numeric($page)) {
            return $this->tabletorder(1);
        }
        if (Session::has($this->sess)) {
            return $this->tabletorder($page, true);
        } else {
            return $this->tabletorder($page);
        }
    }
    public function searchtorder(Request $request)
    {
        Session::put($this->sess, $request->all());
        return $this->tabletorder(1, true);
    }

}
