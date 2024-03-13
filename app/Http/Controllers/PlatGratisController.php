<?php

namespace App\Http\Controllers;
use App\Models\PlatGratis;
use Illuminate\Support\Facades\Session;
use App\Tools\tools;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PlatGratisController extends Controller
{
    //
    protected $sess = 'searchplatgratis';

    public function platgratis()
    {
        Session::forget($this->sess);
        $platgratis = $this->tableplatgratis(1, false, false);
        return view("platgratis.platgratis", compact("platgratis"))->render();
    }


    public  function tableplatgratis($page = 1, $search = false, $ajax = true)
    {
        $platgratis = PlatGratis::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('plat', 'like', '%' . $datasearch . '%');
            }
        })->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($platgratis->lastPage(), $page, 'pageplatgratis');
        $data =  view("platgratis.tableplatgratis", compact("platgratis", "pagination"))->render();

        if (!$ajax) {
            return $data;
        }
        return response()->json([
            "parent" => ".dataPlat",
            "data" => $data
        ]);
    }

    public function pageplatgratis($page)
    {
        if (!is_numeric($page)) {
            return $this->tableplatgratis(1);
        }
        if (Session::has($this->sess)) {
            return $this->tableplatgratis($page, true);
        } else {
            return $this->tableplatgratis($page);
        }
    }
    public function searchplatgratis(Request $request)
    {
        Session::put($this->sess, $request->all());
        return $this->tableplatgratis(1, true);
    }
    public function addplatgratis(Request $request)
    {
        $validasiData = $request->validate([
            'plat' => 'required|max:50',
        ]);
        $validasiData['plat'] = strtoupper($validasiData['plat']);
        PlatGratis::create($validasiData);
        $platgratis = $this->tableplatgratis(1, false, false);
        return response()->json([
            "parent" => ".dataPlat",
            "data" => $platgratis
        ]);
    }
    public function delplatgratis($id)
    {
        try {
            PlatGratis::destroy($id);
        } catch (\Throwable $th) {
        }
        $platgratis = $this->tableplatgratis(1, false, false);
        return response()->json([
            "parent" => ".dataPlat",
            "data" => $platgratis
        ]);
    }

    public function showplatgratis($id)
    {
        $platgratis = PlatGratis::findorFail($id);
        // $data = view("");
    }
    public function editplatgratis(Request $request)
    {
        if ($request->ajax()) {
            if ($request->uniq) {
                $validasiData = $request->validate([
                    'plat' => 'required|max:50',
                ]);

                $validasiData['plat'] = strtoupper($validasiData['plat']);
                try {
                    $id = htmlspecialchars($request->uniq);
                    $lb = PlatGratis::findorFail($id);
                    $lb->update($validasiData);
                } catch (\Throwable $th) {
                }
                return $this->tableplatgratis();
            }
        }
    }
    public function dataPlatgratis()
    {
        $plat =PlatGratis::pluck('plat')->toArray();
        return $plat;
    }
}
