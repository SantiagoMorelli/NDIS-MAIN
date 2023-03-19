<?php

namespace App\Console\Commands;

use App\Services\HandShakingServices;
use Illuminate\Console\Command;

class ActivateDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nids:activatedevice';

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
        HandShakingServices::activateDevice();
        return 0;
    }
}
