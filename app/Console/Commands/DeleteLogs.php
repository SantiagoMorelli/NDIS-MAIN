<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NdisExternalApiController;
use Illuminate\Support\Facades\Log;

class DeleteLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nids:deletelogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Logs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NdisExternalApiController $ndisExternal) {
        parent::__construct();
        $this->ndisExternal = $ndisExternal;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->ndisExternal->deleteLogsCron();
        Log::info($data);
    }
}
