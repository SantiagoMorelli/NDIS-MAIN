<?php

namespace App\Console\Commands;

use App\Models\BcmOrder;
use Exception;
use Illuminate\Console\Command;

class ClearAssigned extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:assigned';

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // BcmOrder::where('assigned_to','finished')->update(['assigned_to'=> null]);
        try{
            BcmOrder::where('assigned_to','finished')->update(['assigned_to'=> null]);
        } catch(Exception $e){
            return 'ClearAssignedTo'.$e->getMessage();
        }
        return `ClearAssignedTo :successfully cleared the assigned to`;
    
    }
}
