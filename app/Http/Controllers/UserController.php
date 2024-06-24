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
use App\Http\Controllers\pembelianCon;
use App\Models\layanan;

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
            if(auth()->user()->role == 'Patner'){
                return redirect()->intended('/patnerorder');
            }
            return redirect()->intended('/transaksi');
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
        $tiket = tjual1::with("tjual")->whereHas('tjual', function ($query) {
            $query->where('status', 2);
        })->where(function ($e) use ($search) {
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
        // $tiket = tjual::->where('status', 2)->where(function ($e) use ($search) {
        //     if ($search) {
        //         $e->where('name', 'like', '%' . session($this->sess)['search'] . '%')
        //             ->orwhere('email', 'like', '%' . session($this->sess)['search'] . '%')
        //             ->orwhere('np', 'like', '%' . session($this->sess)['search'] . '%')
        //             ->orwhere('id', 'like', '%' . session($this->sess)['search'] . '%');
        //     } else {
        //         Session::forget($this->sess);
        //     }
        // })->orderby('created_at', 'desc')->paginate(10, ['*'], null, $page);
        // $total = tjual::selectRaw(DB::raw("sum(totalbayar) as tb , sum(qty) tq,count(id) as jum"))->where('status', 2)->first();
        // $pagination = tools::ApiPagination($tiket->lastPage(), $page, 'pagejual');
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
        $transaksi = tjual::with(['by' => function ($e) {
            $e->select('id', 'name');
        }])->where(function ($e) use ($search) {
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
            if (session($this->sess)['sip'] != null) {
                $transaksi->where('sip', session($this->sess)['sip']);
            }
        } else {
            $transaksi->whereBetween('tgl', [date("Y-m-d"), date("Y-m-d")]);
        }
        if (auth()->user()->role != "Admin") {
            if(auth()->user()->role != "Patner"){
                $transaksi->where('input_by', auth()->user()->id);

            }else{
                $transaksi->where('patner_id', auth()->user()->id);
            }
        }
        
        $cut = $transaksi;
        $transaksi = $transaksi->where("status", "berhasil")->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        // return $transaksi;
        $tunai = $cut->where("status", "berhasil")->where("metpem", "tunai")->sum("totalbayar");
        $qris = $cut->where("status", "berhasil")->where("metpem", "qris")->sum("totalbayar");
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pagetransaksi');
        return view("transaksi.tabletransaksi", compact("transaksi", "pagination", "tunai", "qris"))->render();
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
                if ($data->input_by == null) {
                    $data->input_by = auth()->user()->id;
                }
                $data->save();
                // kirim pdf ke email
                $cetak->tiketpdf($data->id);
            }
            return response()->json([
                "success" => true,
                "swal" => true,
                "data" => "<div class='p-1 rounded max-content bg-success text-white d-inline'>Sucess</div>"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "swal" => true,
            ]);
        }
    }
    public function confirmlsg($id, pembelianCon $cetak)
    {
        try {
            $data =  tjual::findOrFail($id);
            if ($data->status == "pending") {
                $data->status = "berhasil";
                $data->save();
                // kirim pdf ke email
                $cetak->tiketpdf($data->id);
            }
            return response()->json([
                "success" => true,
                "swal" => false,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => true,
                "swal" => false,
            ]);
        }
    }
    public function valhp()
    {
        $layanan = layanan::where("type", 0)->get();
        return view('admin.valhp', compact('layanan'));
    }
    public function admincekproses($slug)
    {
        try {
            // return 'ok';
            $tiket = tjual1::with('tjual')->findorFail(trim($slug));
            $jentiket =  $tiket->tjual->tiket_id == 2 ? "Premium Day" : "Regular Day";
            $tglpremium = tgltiket::where('status', 2)->pluck('tgl')->toArray();
            $tglregular = tgltiket::where('status', 1)->pluck('tgl')->toArray();
            $istgl = false;
            if ($tiket->status == 0  ||  $tiket->status == 4  ||  $tiket->status == 5) {

                if ($tiket->tjual->tiket_id == 2) {
                    if (in_array(date('Y-m-d'), $tglpremium)) {
                        $istgl = true;
                    } else {
                        $datatiket = tiket::find(2);

                        if ($datatiket->isallday == 2) {
                            $istgl = true;
                        } else {
                            $istgl = false;
                        }
                    }
                } else {
                    if (in_array(date('Y-m-d'), $tglregular)) {
                        $istgl = true;
                    } else {
                        $istgl = false;
                    }
                }
            }
            if ($istgl) {
                if ($tiket->status == 0  ||  $tiket->status == 4  ||  $tiket->status == 5) {
                    $tiket->validon = date('Y-m-d  H:i:s');
                    $tiket->status = 2;
                    $tiket->save();
                    $pesan = '1';
                    $tiket->tjual->tiket_id  == 2 ? $pesan = "Tiket berlaku 1 orang (mulai pukul 16.00 WIB)" : $pesan = "Tiket berlaku 1 orang untuk hari Rabu/Kamis/Jumat (16.00 s.d. 21.00) kecuali hari libur nasional";
                    return  response()->json([
                        "status" => 'success',
                        "jentiket" => $jentiket,
                        "pesan" => $pesan
                    ]);
                } elseif ($tiket->status == 2) {
                    return  response()->json([
                        "status" => 'used',
                    ]);
                }
                return  response()->json([
                    "status" => 'invalid',
                ]);
            } else {
                if ($tiket->status == 2) {
                    $dateTimeString = $tiket->validon;
                    $format = 'Y-m-d H:i:s';
                    $dateTime = Carbon::createFromFormat($format, $dateTimeString);
                    $formattedDateTime = $dateTime->format('d M Y, H:i A');
                    $today = false;
                    if ($dateTime->isToday()) {
                        $formattedDateTime = "Hari ini Jam " . $dateTime->format('H:i A');
                        $today = true;
                    }
                    return  response()->json([
                        "status" => 'used',
                        "pesan" => "Digunakan Pada " . $formattedDateTime,
                    ]);
                } else {
                    if (in_array(date('Y-m-d'), $tglregular)) {
                        $tiket->validon = date('Y-m-d  H:i:s');
                        $tiket->status = 2;
                        $tiket->save();
                        $pesan = '1';
                        $tiket->tjual->tiket_id  == 2 ? $pesan = "Tiket berlaku 1 orang (mulai pukul 16.00 WIB)" : $pesan = "Tiket berlaku 1 orang untuk hari Rabu/Kamis/Jumat (16.00 s.d. 21.00) kecuali hari libur nasional";
                        return  response()->json([
                            "status" => 'success',
                            "jentiket" => $jentiket,
                            "pesan" => $pesan
                        ]);
                    } else {
                        $berlaku = $tiket->tjual->tiket_id == 1 ? "Rabu-Jum'at (Kecuali Libur Nasional)" : "Weekend day & Libur Nasional";
                        $pesan = '1';
                        $tiket->tjual->tiket_id == 2 ? $pesan = "Tiket berlaku 1 orang (mulai pukul 16.00 WIB) <br>
                    
                    Berlaku setiap hari festival (termasuk hari libur nasional, opening day, dan closing day)" : $pesan = "Tiket berlaku 1 orang untuk hari Rabu/Kamis/Jumat (16.00 s.d. 21.00) Opening Day kecuali hari libur nasional";
                        return  response()->json([
                            "status" => 'pending',
                            "jentiket" => $jentiket,
                            "pesan" => $pesan
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            function removech($text, $numCharacters)
            {
                if ($numCharacters >= 0) {
                    return substr($text, 0, -$numCharacters);
                } else {
                    return $text;
                }
            }
            try {
                $tiket = tjual1::where("id", 'like', "%" . removech($slug, 4) . "%")->firstOrFail();
                $jentiket =  $tiket->tjual->tiket_id == 2 ? "Premium Day" : "Regular Day";

                if ($tiket->status == 0  ||  $tiket->status == 4  ||  $tiket->status == 5) {
                    $tiket->validon = date('Y-m-d  H:i:s');
                    $tiket->status = 2;
                    $tiket->save();
                    $pesan = '1';
                    $tiket->tjual->tiket_id  == 2 ? $pesan = "Tiket berlaku 1 orang (mulai pukul 16.00 WIB)" : $pesan = "Tiket berlaku 1 orang untuk hari Rabu/Kamis/Jumat (16.00 s.d. 21.00) kecuali hari libur nasional";
                    return  response()->json([
                        "status" => 'success',
                        "jentiket" => $jentiket,
                        "pesan" => $pesan
                    ]);
                } elseif ($tiket->status == 2) {
                    $dateTimeString = $tiket->validon;
                    $format = 'Y-m-d H:i:s';
                    $dateTime = Carbon::createFromFormat($format, $dateTimeString);
                    $formattedDateTime = $dateTime->format('d M Y, H:i A');
                    $today = false;
                    if ($dateTime->isToday()) {
                        $formattedDateTime = "Hari ini Jam " . $dateTime->format('H:i A');
                        $today = true;
                    }
                    return  response()->json([
                        "status" => 'used',
                        "pesan" => "Digunakan Pada " . $formattedDateTime,
                    ]);
                } else {
                    $berlaku = $tiket->tjual->tiket_id == 1 ? "Rabu-Jum'at (Kecuali Libur Nasional)" : "Weekend day & Libur Nasional";
                    $pesan = '1';
                    $tiket->tjual->tiket_id == 2 ? $pesan = "Tiket berlaku 1 orang (mulai pukul 16.00 WIB) <br>
                    Berlaku setiap hari festival (termasuk hari libur nasional, opening day, dan closing day)" : $pesan = "Tiket berlaku 1 orang untuk hari Rabu/Kamis/Jumat (16.00 s.d. 21.00) Opening Day kecuali hari libur nasional";
                    return  response()->json([
                        "status" => 'pending',
                        "jentiket" => $jentiket,
                        "pesan" => $pesan
                    ]);
                }
            } catch (\Throwable $th) {
                return  response()->json([
                    "status" => 'invalid',
                    "data" => ''
                ]);
            }
        }
    }
    //Tampil Transaksi

    public function torder()
    {
        Session::forget($this->sess);
        $transaksi = $this->tabletorder();
        return view("transaksi.torder", compact("transaksi"))->render();
    }


    public  function tabletorder($page = 1, $search = false)
    {
        $transaksi =
            tjual::where(function ($e) use ($search) {
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
        $transaksi = $transaksi->where(["status"=> "pending", "patner_id" => null])->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pending = true;
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pagetorder');
        return view("transaksi.tabletorder", compact("transaksi", "pagination", "pending"))->render();
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

    //Transaksi Gagal
    public function tgagal()
    {
        Session::forget($this->sess);
        $transaksi = $this->tabletgagal();
        return view("transaksi.tgagal", compact("transaksi"))->render();
    }


    public  function tabletgagal($page = 1, $search = false)
    {
        $transaksi =
            tjual::where(function ($e) use ($search) {
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
        $transaksi = $transaksi->where("status", "expired")->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pending = true;
        $pagination = tools::ApiPagination($transaksi->lastPage(), $page, 'pagetgagal');
        return view("transaksi.tabletgagal", compact("transaksi", "pagination", "pending"))->render();
    }

    public function pagetgagal($page)
    {
        if (!is_numeric($page)) {
            return $this->tabletgagal(1);
        }
        if (Session::has($this->sess)) {
            return $this->tabletgagal($page, true);
        } else {
            return $this->tabletgagal($page);
        }
    }
    public function searchtgagal(Request $request)
    {
        Session::put($this->sess, $request->all());
        return $this->tabletgagal(1, true);
    }

    public function detail($id)
    {
        $tjual =  tjual::with('dataorder', 'addon')->where("id", $id)->first();
        $data =  view('transaksi.tabledetail', compact("tjual"))->render();

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }

    
}
