<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\tjual;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;

class cronjob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek pesanan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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

        //
        $order2 = tjual::where(['type_layanan'=> 1, 'isaktif'=>1])->get();
        foreach ($order2 as $od) {
            //cek apakah $od kolom jarak hari end_date dari sekarang, kemudian update sisa_durasi, jika end_date sudah lewat maka update is_aktif jadi 0 dan sisa_durasi jadi 0
            // Ambil tanggal akhir (end_date) dari record
            $endDate = Carbon::parse($od->end_at);
            $now = Carbon::now();

            // Hitung jarak hari dari sekarang ke end_date
            $daysDifference = $now->diffInDays($endDate, false);

            if ($daysDifference >= 0) {
                // Jika end_date belum lewat, update sisa_durasi
                $od->sisa_durasi = $daysDifference;
            } else {
                // Jika end_date sudah lewat, update is_aktif jadi 0 dan sisa_durasi jadi 0
                $od->isaktif = 0;
                $od->sisa_durasi = 0;
            }
            $od->save();
            $this->info($od->id." ".$daysDifference);
        }
    }
}
