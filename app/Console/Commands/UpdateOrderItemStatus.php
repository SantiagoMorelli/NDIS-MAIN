<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ManagementPortal\OrderController;
use Illuminate\Support\Facades\Log;

class UpdateOrderItemStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nids:updateorderitemstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Order Item Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderController $order) {
        parent::__construct();
        $this->order = $order;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->order->updateOrderItemStatusCron();
        Log::info($data);
    }
}
