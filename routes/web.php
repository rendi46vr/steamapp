<?php

use App\Http\Controllers\midtansCon;
use App\Http\Controllers\pembelianCon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserController;
use App\Models\tgltiket;
use Illuminate\Http\Request;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\ipaymuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\layananController;
use App\Http\Controllers\memberController;
use App\Http\Controllers\layanantambahanController;
use App\Http\Controllers\userCon;
use App\Http\Controllers\PlatGratisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('validation', function (Request $request) {
    $class = $request->class;
    $class = str_replace('/', '\\', $class);
    $my_request = new $class();
    if ($request->uniq) {
        $rules = $my_request->rules([0 => $request->uniq]);
    } else {
        $rules = $my_request->rules();
    }
    $validator = Validator::make($request->all(), $rules, $my_request->messages());
    $validator->setAttributeNames($my_request->attributes());
    if ($request->ajax()) {
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ));
        } else {
            return response()->json(array(
                'success' => true,
            ));
        }
    }
});

Route::get('login', [UserController::class, "login"])->name('login');
Route::post('proses_login', [UserController::class, "proses_login"]);
Route::get('logout', [UserController::class, "logout"]);
Route::get('/', [pembelianCon::class, 'index']);
Route::get('form-order/{slug}', [pembelianCon::class, 'formorder']);
Route::post('order', [pembelianCon::class, 'order']);
Route::post("tambahlayanan", [pembelianCon::class, "tambahlayanan"]);
Route::GET('payment/{slug}', [ipaymuController::class, 'payment']);
Route::post('cekTransaksi/{slug}', [ipaymuController::class, 'cek']);
Route::get('cetaknota/{slug}', [pembelianCon::class, 'cetaknota']);
Route::post('find/{id}', [pembelianCon::class, 'find']);

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login']], function () {
        Route::get('dashboard', [userCon::class, "index"]);
        Route::get('seeting/wa', [userCon::class, "settingwa"]);

        //adduser
        Route::post('adduser', [userCon::class, "adduser"]);
        Route::post('cpass', [userCon::class, "cpass"]);
        Route::post('resetpass/{id}', [userCon::class, "resetpassword"]);

        //transaksi Berhasil
        Route::get('transaksi', [UserController::class, "transaksi"]);
        Route::post('pagetransaksi/{page}', [UserController::class, "pagetransaksi"]);
        Route::post('searchtransaksi/{serach}', [UserController::class, "searchtransaksi"]);
        Route::post('confirm/{id}', [UserController::class, "confirm"]);
        Route::post('detail/{id}', [UserController::class, "detail"]);
        Route::post('confirmlsg/{id}', [UserController::class, "confirmlsg"]);
        Route::post('admincek/{slug}', [UserController::class, "admincekproses"]);

        //Tampil Oder
        Route::get('torder', [UserController::class, "torder"]);
        Route::post('pagetorder/{page}', [UserController::class, "pagetorder"]);
        Route::post('searchtorder/{serach}', [UserController::class, "searchtorder"]);

        //Tampil Transaksi Gagal
        Route::get('tgagal', [UserController::class, "tgagal"]);
        Route::post('pagetgagal/{page}', [UserController::class, "pagetgagal"]);
        Route::post('searchtgagal/{serach}', [UserController::class, "searchtgagal"]);
        //layanan
        Route::get('layanan', [layananController::class, "layanan"]);
        Route::post('pagelayanan/{page}', [layananController::class, "pagelayanan"]);
        Route::post('searchlayanan/{serach}', [layananController::class, "searchlayanan"]);
        Route::post('addlayanan', [layananController::class, "addlayanan"]);
        Route::post('dellayanan/{id}', [layananController::class, "dellayanan"]);
        Route::post('editlayanan', [layananController::class, "editlayanan"]);
        Route::post('lstatus/{id}', [layananController::class, "lstatus"]);
        //layanan tambahan
        Route::get('layanantambahan', [layanantambahanController::class, "layanantambahan"]);
        Route::post('pagelayanantambahan/{page}', [layanantambahanController::class, "pagelayanantambahan"]);
        Route::post('searchlayanantambahan/{serach}', [layanantambahanController::class, "searchlayanantambahan"]);
        Route::post('addlayanantambahan', [layanantambahanController::class, "addlayanantambahan"]);
        Route::post('dellayanantambahan/{id}', [layanantambahanController::class, "dellayanantambahan"]);
        Route::post('editlayanantambahan', [layanantambahanController::class, "editlayanantambahan"]);
        // Route::post('showlayanantambahan/{id}', [layanantambahanController::class, "showlayanantambahan"]);
        Route::post('lbstatus/{id}', [layanantambahanController::class, "lbstatus"]);
        //member
        Route::post('addmember/{id}', [memberController::class, "create"]);


        //platgratis
        Route::get('platgratis', [PlatGratisController::class, "platgratis"]);
        Route::post('pageplatgratis/{page}', [PlatGratisController::class, "pageplatgratis"]);
        Route::post('searchplatgratis/{serach}', [PlatGratisController::class, "searchplatgratis"]);
        Route::post('addplatgratis', [PlatGratisController::class, "addplatgratis"]);
        Route::post('delplatgratis/{id}', [PlatGratisController::class, "delplatgratis"]);
        Route::post('editplatgratis', [PlatGratisController::class, "editplatgratis"]);
        Route::post('lstatus/{id}', [PlatGratisController::class, "lstatus"]);

        //laporan
        Route::get('laporan', [LaporanController::class,'index']);
        Route::get('laporan/plat', [LaporanController::class,'laporanKendaraan']);
        Route::post('searchperplat/{search?}', [LaporanController::class,'searchperplat']);
        Route::post('pageperplat/{page}', [LaporanController::class,'pageperplat']);
        Route::get('laporan/plat/{bg}', [LaporanController::class,'filterLaporanKendaraan']);
        Route::post('laporan/{search?}', [LaporanController::class,'filterindex']);
    });
});
Route::get('tiket/{id}', [pembelianCon::class, "tiket"]);
Route::post('cqty', [pembelianCon::class, "cqty"]);
Route::get('scan', [memberController::class, "scan"]);
Route::post('memberorder/{id}', [memberController::class, "memberorder"]);
Route::post('belilagi/{id}', [memberController::class, "belilagi"]);
Route::get('tes', [ipaymuController::class, "tesorder"]);
Route::get('navhide', [memberController::class, "navhide"]);
Route::get('valhp', [UserController::class, "valhp"]);
Route::get('print', function () {
    return view("invoice");
});
Route::get('nota/{slug}', [pembelianCon::class, "cetaknota"]);
Route::get('teskirim/{slug}', [pembelianCon::class, "tiketpdf"]);

Route::get('test', [pembelianCon::class, "test"]);
