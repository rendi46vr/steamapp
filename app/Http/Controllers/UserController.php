<?php

namespace App\Http\Controllers;

use App\Models\tgltiket;
use App\Models\tiket;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\tjual;
use App\Models\tjual1;
use App\Tools\tools;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Node\CrapIndex;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMail;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{

    protected $sess = 'searchjual';
    public function login()
    {
        // dd(session()->all());
        return view('login');
    }
    public function proses_login(Request $request)
    {
        $kredensial = $request->validate(
            [
                'name' => 'required|string|max:100',
                'password' => 'required|string',
            ]
        );


        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect("login")->withSuccess('Login Gagal, silahkan coba lagi!.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return Redirect('/');
    }
    public function dashboard(DiskonController $ds)
    {
        $diskon = $ds->datadiskon();
        $data = tiket::all();
        return view('dashboard', compact('data', 'diskon'));
    }



    public function ctiket()
    {
        $tiket = $this->datatiket();

        return view('admin.ctiket', compact('tiket'));
    }

    public function datatiket($msg = null, $page = 1)
    {
        // if (auth()->user()->role < 2) {
        //     $tiket = tjual::with('user')->where('status', 4)->where('user_id', auth()->user()->id)->orderby('created_at', 'desc')->paginate(10, ['*'], null, $page);
        // } else {
        $tiket = tjual::with('user')->where('status', 4)->where('user_id', '!=', null)->orderby('created_at', 'desc')->paginate(10, ['*'], null, $page);
        // }

        $pagination = tools::ApiPagination($tiket->lastPage(), $page, 'pagetiket');

        return view('admin.tabletiket', compact('tiket', 'pagination'))->render();
    }
    public function pagetiket($page)
    {
        return $this->datatiket(null, $page);
    }

    public function cetakTiket(Request $request)
    {
        $validasiData = $request->validate([
            'qty' => 'required',
            'tgl' => '',
            'jenis_tiket' => 'required|max:1',
        ]);
        $user = auth()->user();
        $paket = tiket::find($validasiData['jenis_tiket']);
        $validasiData['tgljual'] = date('Y-m-d');
        $validasiData['name'] = "Admin";
        $pool = '0123456789';
        $uniq = substr(str_shuffle(str_repeat($pool, 5)), 0, 8);
        $validasiData['np'] = "NP" . date('Y-m-d') . $uniq;
        $validasiData['status'] = 4;
        $validasiData['id'] = Str::uuid();
        $validasiData['tiket_id'] = $paket->id;
        $validasiData['user_id'] = $user->id;
        $data = tjual::create($validasiData);

        $index = $paket->index;

        $paket->update([
            "index" => $index + $validasiData['qty'],
        ]);
        $paket->save();
        for ($i = 1; $i <= $data->qty; $i++) {
            tjual1::create([
                'id' => Str::uuid(),
                'tjual_id' => $data->id,
                'status' => 0,
                'nourut' => $index + $i,

            ]);
        }
        return $this->datatiket();
    }
    public function penjualan()
    {
        $tiket = $this->datapenjualan();
        return view('penjualan.jual', compact('tiket'));
    }
    public function datapenjualan($msg = null, $page = 1, $search = false)
    {
        $tiket = tjual::where('status', 2)->where(function ($e) use ($search) {
            if ($search) {
                $e->where('name', 'like', '%' . session($this->sess)['search'] . '%')
                    ->orwhere('email', 'like', '%' . session($this->sess)['search'] . '%')
                    ->orwhere('np', 'like', '%' . session($this->sess)['search'] . '%')
                    ->orwhere('id', 'like', '%' . session($this->sess)['search'] . '%');
            } else {
                Session::forget($this->sess);
            }
        })->orderby('created_at', 'desc')->paginate(10, ['*'], null, $page);
        $total = tjual::selectRaw(DB::raw("sum(totalbayar) as tb , sum(qty) tq,count(id) as jum"))->where('status', 2)->first();
        $pagination = tools::ApiPagination($tiket->lastPage(), $page, 'pagejual');
        // return print_r($tiket->count());
        return view('penjualan.tablejual', compact('tiket', 'pagination', 'total'))->render();
    }
    public function pagejual($page)
    {
        if (Session::has($this->sess)) {
            return $this->datapenjualan(null, $page, true);
        } else {
            return $this->datapenjualan(null, $page);
        }
    }

    public function searchjual(Request $request)
    {

        Session::put($this->sess, $request->all());
        return $this->datapenjualan(null, 1, true);
    }

    public function transaksi()
    {
        Session::forget($this->sess);
        $transaksi = $this->tabletransaksi();
        return view("transaksi.transaksi", compact("transaksi"))->render();
    }


    public  function tabletransaksi($page = 1, $search = false)
    {
        $transaksi = tjual::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('plat', 'like', '%' . $datasearch . '%')
                    ->orwhere('email', 'like', '%' . $datasearch . '%')
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
        $transaksi = $transaksi->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pagetransaksi');
        return view("transaksi.tabletransaksi", compact("transaksi", "pagination"))->render();
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

    public function confirm($id, pembelianCon $cetak)
    {
        try {
            $data =  tjual::findOrFail($id);
            if ($data->status == "pending") {
                $data->status = "berhasil";
                $data->save();
            }
            return "<div class='p-1 rounded bg-success text-white'>Sucess</div>";
        } catch (\Throwable $th) {
            return "<div class='p-1 rounded bg-danger text-white'>Failed</div>";
        }
    }
}
