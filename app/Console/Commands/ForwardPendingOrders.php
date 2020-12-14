<?php

namespace App\Console\Commands;

use App\Jobs\PendingOrderForward;
use Illuminate\Console\Command;

class ForwardPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:pending-order-Forward';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Order forward pending from 1 hour';

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
        PendingOrderForward::dispatch();
    }
}
