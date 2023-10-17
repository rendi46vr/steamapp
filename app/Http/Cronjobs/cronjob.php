<?php

namespace App\Http\Cronjobs;

use App\Models\tjual;
use DateTime;
use Illuminate\Support\Facades\Log;

//Star cronjob
Log::info("=============== Cronjob Start ==================");
$order = tjual::where("status", "pending")->orderBy("created_at", "asc")->get();
foreach ($order as $p) {
    $tgl1 = new DateTime($p->created_at);
    $tgl2 = new DateTime(date("Y-m-d H:i:s"));
    $jarak = $tgl2->diff($tgl1);
    if ($jarak->d >= 1) {
        $p->update([
            "status" => "expired",
        ]);
    }
    Log::info("Cron job melakukan update pada orderan dengan id =  $p->id  !");
}
Log::info("=============== Cronjob finish =================");
