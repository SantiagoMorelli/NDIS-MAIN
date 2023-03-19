<?php

namespace App\Console\Commands;

use App\Models\BcmOrder;
use App\Models\Ticketing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrackingProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:progress';
    public static $newInterval=10;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
     
    }
    public static function set_checking_interval($newInterval){
        self::$newInterval=$newInterval;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $interval=self::$newInterval;
    
        $orders=BcmOrder::where('created_at','>=',date('Y-m-d',strtotime('2022-08-01')))->where('order_status','<','10')->where('updated_at','<=', DB::raw('DATE_SUB(NOW(), INTERVAL '.$interval.' DAY)') )->get()->toArray();
    if($orders){
        foreach($orders as $order){
            $checkTicket= Ticketing::where(['subject'=>'progress check',"order_number"=>$order['order_number']])->where(function($query){
                $query->where('status','processing')->orWhere('status','open');
            })->get()->toArray();
           
            if(count($checkTicket)==0){
                Ticketing::Create(['subject'=>'progress check','type'=>'2','status'=>'open','notes'=>'The status of order '.$order['order_number'].' hasn\'t been updated in last 10 days, please check the order progress','order_number'=>$order['order_number'],'due_date'=>date("Y/m/d")]);
            }
        }
    }
            error_log(self::$newInterval);

            
        // }
        

        return true;
    }
}
