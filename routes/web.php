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
use App\Http\Controllers\layananController;
use App\Http\Controllers\memberController;

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

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login']], function () {
        Route::get('dashboard', [UserController::class, "dashboard"]);
        Route::get('transaksi', [UserController::class, "transaksi"]);
        Route::post('pagetransaksi/{page}', [UserController::class, "pagetransaksi"]);
        Route::post('searchtransaksi/{serach}', [UserController::class, "searchtransaksi"]);
        Route::post('confirm/{id}', [UserController::class, "confirm"]);

        //layanan
        Route::get('layanan', [layananController::class, "layanan"]);
        Route::post('pagelayanan/{page}', [layananController::class, "pagelayanan"]);
        Route::post('searchlayanan/{serach}', [layananController::class, "searchlayanan"]);
        Route::post('addlayanan', [layananController::class, "addlayanan"]);
        Route::post('dellayanan/{id}', [layananController::class, "dellayanan"]);
        Route::post('editlayanan/{id}', [layananController::class, "editlayanan"]);
        Route::post('showlayanan/{id}', [layananController::class, "showlayanan"]);
        //member
        Route::post('addmember/{id}', [memberController::class, "create"]);
    });
});
Route::get('tiket/{id}', [pembelianCon::class, "tiket"]);

Route::get('scan', [memberController::class, "scan"]);
Route::post('memberorder/{id}', [memberController::class, "memberorder"]);
Route::post('belilagi/{id}', [memberController::class, "belilagi"]);
Route::get('tes', [ipaymuController::class, "tesorder"]);
Route::get('navhide', [memberController::class, "navhide"]);
Route::get('print', function () {
    return view("invoice");
});

Route::get('nota/{slug}', [pembelianCon::class, "cetaknota"]);
Route::get('teskirim/{slug}', [pembelianCon::class, "tiketpdf"]);
