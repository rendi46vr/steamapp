<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\layanan;
use App\Models\layanantambahan;
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
            // 'harga' => 'numeric:max:20',
            // 'diskon' => 'numeric|lt:harga',
            'type' => 'string|max:1',
            'qtyoption' => 'numeric',
            'durasi' => 'string|max:255',
        ]);
        $validasiData["slug"] =  Str::slug($validasiData["layanan"], "-");
        if($request->type == 1){
            $validasiData['durasi'] =  $request->durasi;
        }
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
        // $data = view("");
    }
    public function editlayanan(Request $request)
    {
        if ($request->ajax()) {
            if ($request->uniq) {
                $validasiData = $request->validate([
                    'layanan' => 'required|max:255',
                    'deskripsi' => 'required',
                    'harga' => 'required:number:max:20',
                    'diskon' => 'numeric|lt:harga',
                    'qtyoption' => 'required:number:max:99',
                ]);
                try {
                    $id = htmlspecialchars($request->uniq);
                    $lb = layanan::findorFail($id);
                    $lb->update($validasiData);
                } catch (\Throwable $th) {
                }
                return $this->tablelayanan();
            }
        }
    }
    public function lstatus($id)
    {
        try {
            $layanan = layanan::findorfail($id);
            if ($layanan->isaktif > 0) {
                $layanan->isaktif = 0;
                $layanan->save();
                return "<input class='custom-control-input' type='checkbox' id='$id'> <label class='custom-control-label text-dark' for='$id'>Off</label>";
            } else {
                $layanan->isaktif = 1;
                $layanan->save();
                return "<input class='custom-control-input' checked type='checkbox' id='$id'> <label class='custom-control-label text-success' for='$id'>On</label>";
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
