<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NdisAuthenticationController;
use Illuminate\Support\Facades\Log;

class RefreshDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nids:refreshdevice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Device';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NdisAuthenticationController $ndisAuthenticate) {
        parent::__construct();
        $this->ndisAuthenticate = $ndisAuthenticate;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->ndisAuthenticate->refreshDeviceCron();
        Log::info($data);
    }
}
