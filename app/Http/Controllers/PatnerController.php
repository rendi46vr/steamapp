<?php

namespace App\Http\Controllers;

use App\Http\Requests\patner\addpatner;
use App\Models\layanan;
use App\Models\LayananPatner;
use App\Models\Patner;
use App\Models\User;
use App\Tools\tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatnerController extends Controller
{
    //
    protected $sess ='searchPatner';

    public function index(){
        $data= [];
        $data['title'] = "Daftar Partnership";

        $data['patner'] = $this->tablepatner(1, false, false);
        return view('patner.patner',$data);
    }

    public  function tablepatner($page = 1, $search = false, $ajax = true)
    {
        $patner = Patner::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('nama_patner', 'like', '%' . $datasearch . '%');
            }
        })->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($patner->lastPage(), $page, 'pagelayanan');
        $data =  view("patner.tablepatner", compact("patner", "pagination"))->render();

        if (!$ajax) {
            return $data;
        }
        return response()->json([
            "parent" => ".dataPatner",
            "data" => $data
        ]);

    }

    public function  addpatner(addpatner $request){

        DB::transaction(function() use ($request) {
            try {
                $data =$request->all();
                $patner = Patner::create($data);

                $patner = User::create([
                    "name" => $patner->email,
                    "email" => $patner->email,
                    "role" => "Patner",
                    "patner_id" => $patner->id,
                    "password" => Hash::make($patner->email)
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        });
        return $this->tablepatner();
     }
 
     public function editpatner(Request $request){

        DB::transaction(function() use ($request) {
            try {
                $patner = Patner::find($request->uniq);
                $patner->update($request->all());
                $patner->save();

                $user = User::where('patner_id', $patner->id)->first();
                $user->update([
                    "name" => $patner->email,
                    "email" => $patner->email,
                ]);
                $user->save();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        });

         return $this->tablepatner();
     }

     public function lstatus($id)
     {
         try {
             $layanan = Patner::findorfail($id);
             if ($layanan->status > 0) {
                 $layanan->status = 0;
                 $layanan->save();
                 return "<input class='custom-control-input' type='checkbox' id='$id'> <label class='custom-control-label text-dark' for='$id'>Off</label>";
             } else {
                 $layanan->status = 1;
                 $layanan->save();
                 return "<input class='custom-control-input' checked type='checkbox' id='$id'> <label class='custom-control-label text-success' for='$id'>On</label>";
             }
         } catch (\Throwable $th) {
             //throw $th;
         }
    }

    public function layananPatner($id){
        $data= [];
        $data['title'] = " Layanan Patner";
        $data['patner'] = Patner::with('layanan')->find($id);
        $data['layananIds'] = $data['patner']->layanan->pluck('layanan_id')->toArray();
        $data['layanan'] = layanan::all();
        return view('patner.layanan-patner',$data);
    }

    public function addLayananPatner(Request $request){

        try {
            if(is_array($request->tambahan)){

            $layanan = layanan::wherein('id',$request->tambahan)->get();
            if($layanan){
                //tambah layananPatner sesuai $layanan->layanan
                foreach($layanan as $l){
                    LayananPatner::updateOrCreate ([
                        'patner_id' => $request->patner_id,
                        'layanan_id' => $l->id
                    ],[
                        'patner_id' => $request->patner_id,
                        'layanan_id' => $l->id,
                        'name' => $l->layanan
                    ]);
                    LayananPatner::where('patner_id', $request->patner_id)->whereNotIn('layanan_id', $request->tambahan)->delete();
                }
            }
           
        }else{
            LayananPatner::where('patner_id', $request->patner_id)->delete();
        }
        return response()->json([
            'status' => true,
         ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
               'status' => false,
               'message' => $th->getMessage()
            ]);
        }

    }
}
