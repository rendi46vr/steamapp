<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userCon extends Controller
{
    public function index()
    {
        $users = $this->users();
        $data = tiket::all();
        return view('dashboard', compact('data', 'users'));
    }
    public function users($msg = "")
    {
        $users = User::select('id', 'name', 'email', 'role')->where("role", "!=", "member")->get();
        return view('user.tableuser', compact('users', "msg"))->render();
    }

    public function adduser(Request $request)
    {
        $validasiData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|max:20',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('12345678');
        $user->role = $request->role;
        $user->save();

        return  response()->json([
            "status" => true,
            "parent" => ".data-user",
            "data" => $this->users()
        ]);
    }
    public function cpass(Request $request)
    {
        $request->validate([
            'passwordlama' => 'required',
            'passbaru' => 'required|min:8|same:cpassbaru',
            'cpassbaru' => 'required',
        ]);

        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->passwordlama, $user->password)) {
            return response()->json([
                "status" => true,
                "success" => false,
                "parent" => ".messagepass",
                "data" => "Password Salah"
            ]);
        }
        $user->password = Hash::make($request->passbaru);
        $user->save();

        return response()->json([
            "status" => true,
            "success" => true,
            "parent" => ".messagepass",
            "data" => "Password Berhasil diganti"
        ]);
    }
    public function resetpassword($iduser)
    {
        $user = User::find($iduser);
        if (!$user) {
            return "User Invalid";
        }
        $user->password = Hash::make('12345678'); // Reset password ke '12345678' atau password default yang Anda inginkan
        $user->save();
        return "Password  " . $user->name . " direset";
    }


    public function settingwa()
    {
        return view('setting.whatsapp');
    }
}
