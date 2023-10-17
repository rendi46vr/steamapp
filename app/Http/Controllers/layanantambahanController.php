<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\layanantambahan;
use Illuminate\Support\Facades\Session;
use App\Tools\tools;
use Illuminate\Support\Str;

class layanantambahanController extends Controller
{
    protected $sess = 'searchlayanantambahan';

    public function layanantambahan()
    {
        Session::forget($this->sess);
        $layanantambahan = $this->tablelayanantambahan(1, false, false);
        return view("layanantambahan.layanantambahan", compact("layanantambahan"))->render();
    }


    public  function tablelayanantambahan($page = 1, $search = false, $ajax = true)
    {
        $layanantambahan = layanantambahan::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('layanan', 'like', '%' . $datasearch . '%')
                    ->orwhere('harga', 'like', '%' . $datasearch . '%');
            }
        })->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($layanantambahan->lastPage(), $page, 'pagelayanantambahan');
        $data =  view("layanantambahan.tablelayanantambahan", compact("layanantambahan", "pagination"))->render();

        if (!$ajax) {
            return $data;
        }
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $data
        ]);
    }

    public function pagelayanantambahan($page)
    {
        if (!is_numeric($page)) {
            return $this->tablelayanantambahan(1);
        }
        if (Session::has($this->sess)) {
            return $this->tablelayanantambahan($page, true);
        } else {
            return $this->tablelayanantambahan($page);
        }
    }
    public function searchlayanantambahan(Request $request)
    {
        Session::put($this->sess, $request->all());
        return $this->tablelayanantambahan(1, true);
    }


    public function addlayanantambahan(Request $request)
    {
        $validasiData = $request->validate([
            'layanan' => 'required|max:255',
            'harga' => 'required:number:max:20',
            'diskon' => 'numeric|lte:harga',
        ]);
        $validasiData["id"] = Str::uuid();
        layanantambahan::create($validasiData);
        $layanantambahan = $this->tablelayanantambahan(1, false, false);
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $layanantambahan
        ]);
    }
    public function dellayanantambahan($id)
    {
        try {
            layanantambahan::destroy($id);
        } catch (\Throwable $th) {
        }
        $layanantambahan = $this->tablelayanantambahan(1, false, false);
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $layanantambahan
        ]);
    }

    public function showlayanantambahan($id)
    {
        $layanantambahan = layanantambahan::findorFail($id);
        $data = view("");
    }

    public function editlayanantambahan(Request $request)
    {
        if ($request->ajax()) {
            if ($request->uniq) {
                $validasiData = $request->validate([
                    'layanan' => 'required|max:255',
                    'harga' => 'required:number:max:20',
                    'diskon' => 'numeric|lte:harga',

                ]);
                try {
                    $id = htmlspecialchars($request->uniq);
                    $lb = layanantambahan::findorFail($id);
                    $lb->update($validasiData);
                } catch (\Throwable $th) {
                }
                return $this->tablelayanantambahan();
            }
        }
    }
    public function lbstatus($id)
    {
        try {
            $layanantambahan = layanantambahan::findorfail($id);
            if ($layanantambahan->isaktif > 0) {
                $layanantambahan->isaktif = 0;
                $layanantambahan->save();
                return "<input class='custom-control-input' type='checkbox' id='$id'> <label class='custom-control-label text-dark' for='$id'>Off</label>";
            } else {
                $layanantambahan->isaktif = 1;
                $layanantambahan->save();
                return "<input class='custom-control-input' checked type='checkbox' id='$id'> <label class='custom-control-label text-success' for='$id'>On</label>";
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
