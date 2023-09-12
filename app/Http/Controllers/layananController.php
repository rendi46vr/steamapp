<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\layanan;
use Illuminate\Support\Facades\Session;
use App\Tools\tools;
use Illuminate\Support\Str;

class layananController extends Controller
{
    protected $sess = 'searchlayanan';

    public function layanan()
    {
        Session::forget($this->sess);
        $layanan = $this->tablelayanan(1, false, false);
        return view("layanan.layanan", compact("layanan"))->render();
    }


    public  function tablelayanan($page = 1, $search = false, $ajax = true)
    {
        $layanan = layanan::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('layanan', 'like', '%' . $datasearch . '%')
                    ->orwhere('deskripsi', 'like', '%' . $datasearch . '%');
            }
        })->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($layanan->lastPage(), $page, 'pagelayanan');
        $data =  view("layanan.tablelayanan", compact("layanan", "pagination"))->render();

        if (!$ajax) {
            return $data;
        }
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $data
        ]);
    }

    public function pagelayanan($page)
    {
        if (!is_numeric($page)) {
            return $this->tablelayanan(1);
        }
        if (Session::has($this->sess)) {
            return $this->tablelayanan($page, true);
        } else {
            return $this->tablelayanan($page);
        }
    }
    public function searchlayanan(Request $request)
    {
        Session::put($this->sess, $request->all());
        return $this->tablelayanan(1, true);
    }


    public function addlayanan(Request $request)
    {
        $validasiData = $request->validate([
            'layanan' => 'required|max:255',
            'deskripsi' => 'required',
            'harga' => 'required:number:max:20',
            'qtyoption' => 'required:number:max:99',
        ]);
        $validasiData["slug"] =  Str::slug($validasiData["layanan"], "-");
        layanan::create($validasiData);
        $layanan = $this->tablelayanan(1, false, false);
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $layanan
        ]);
    }
    public function dellayanan($id)
    {
        try {
            layanan::destroy($id);
        } catch (\Throwable $th) {
        }
        $layanan = $this->tablelayanan(1, false, false);
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $layanan
        ]);
    }

    public function showlayanan($id)
    {
        $layanan = layanan::findorFail($id);
        $data = view("");
    }
}
