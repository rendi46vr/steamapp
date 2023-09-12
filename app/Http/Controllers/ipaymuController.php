<?php

namespace App\Http\Controllers;

use App\Models\payget;
use App\Models\pesanan;
use App\Models\tjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ipaymuController extends Controller
{
    public function index()
    {

        $data = self::metodePembayaran();
        $input = [];
        foreach ($data["Data"] as $d) {

            $input = [
                'code' => $d['Code'],
                'description' => $d['Description'],
            ];
            if (isset($d["PaymentMethod"])) {
                foreach ($d["PaymentMethod"] as $c) {
                    $input['channel_code'] = $c['Code'];
                    $input['channel_description'] = $c['Description'];
                    $input['payment_instructions_doc'] = $c['PaymentIntrucionsDoc'];
                    $input['transaction_fee_actual'] = $c['TransactionFee']['ActualFee'];
                    $input['transaction_fee_type'] = $c['TransactionFee']['ActualFeeType'];
                    $input['transaction_fee_additional'] = $c['TransactionFee']['AdditionalFee'];
                }
            }

            // return dd($d);

        }
        exit;
        // tes 
        // dd($this->reqPayment());
        return redirect($this->reqPayment()["Url"]);


        //real
        return view("index1", compact("data"));
    }





    protected function reqIpay($body, $url = "v2/payment-method-list")
    {
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper("POST") . ':' . env("PAY_VA") . ':' . $requestBody . ':' .  env("PAY_KEY");
        $data = Http::withHeaders([
            "Content-type" => "aplication/json",
            "va" => env("PAY_VA"),
            "signature" => hash_hmac('sha256', $stringToSign, env("PAY_KEY")),
            "timestamp" => Date('YmdHis')
        ])->POST(env("PAY_URL") . $url, $body);

        $res = json_decode($data->body(), true);

        return $res;
    }


    public static function metodePembayaran()
    {
        return  self::reqIpay(["account" => env("PAY_VA")], "v2/payment-method-list");
    }


    public function reqPayment($body = [])
    {
        // $body['product']    = array('headset', 'softcase');
        // $body['qty']        = array('1', '3');
        // $body['amount']        = "3000000";
        // $body['price']      = array('10000000', '2000000');
        $body['returnUrl']  = url('testreturn');
        $body['cancelUrl']  = url('/canceltes');
        $body['notifyUrl']  = url('/ipaymucallback17');
        $body["feeDirection"] =  "BUYER";

        $req =  $this->reqIpay($body, "v2/payment/direct");

        if ($req["Status"] == 200) {
            return $req;
        }

        if ($req->Status) {
            return json_decode($req->body());
        }
    }

    public function reqPaymentRedirect($body = [])
    {
        $body['returnUrl']  = url('testreturn');
        $body['cancelUrl']  = url('/canceltes');
        $body['notifyUrl']  = url('/ipaymucallback17');
        $body["feeDirection"] =  "BUYER";
        $req =  $this->reqIpay($body, "v2/payment");

        if ($req["Status"] == 200) {
            return $req;
        }

        if ($req->Status) {
            return json_decode($req->body());
        }
    }


    public function payment($slug)
    {
        $pay = tjual::with(["dataorder", "payget", "payment"])->findOrFail($slug);
        // dd($pay->payment);
        return view("payment.payment", compact("pay"));
    }

    public function callback(Request $request)
    {
        // return response($request);
        try {

            $transaksi = tjual::where("np", $request->sid)->firstOrFail();
            // if ($request->status_code == 1) {
            // } elseif ($request->status_code == 0) {
            // }
            $transaksi->status = $request->status;
            $transaksi->save();
            return ":)";
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function tesorder()
    {
        return  $reqPayment = self::reqPaymentRedirect([
            'product' => ["asdadasd"],
            'qty' => ["1"],
            'amount' => 50000,
            'price' => [50000],
            'referenceId' =>  strval("asjldadlasaskd"),
            // 'paymentMethod' => "va",
            // 'paymentChannel' => $mpem->channel_code,
            'buyerName' => "testing",
            'buyerPhone' => "08121238091231",
            'buyerEmail' => "rendi46vr@gmail.com"
        ]);
    }


    public function cek($slug, pembelianCon $cetak)
    {
        try {
            $cek = tjual::findOrFail($slug);
            $pdf = $cetak->cetaknota($slug);
            if ($cek->status == "berhasil") {
                $res = array('success' => true, 'message' => 'Berhasil', "data" => $pdf);
            } else if ($cek->status == "pending") {
                $res = array('success' => false, 'message' => $cek->status);
            } else {
                $res = array('success' => false, 'message' => "Expired");
            }
        } catch (\Throwable $th) {
            $res = array('success' => false, 'message' => 'Gagal');
        }
        return $res;
    }
}
