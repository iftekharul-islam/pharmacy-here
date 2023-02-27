<?php

namespace App\Console\Commands;

use App\Imports\PharmacyImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportPharmacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pharmacy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Pharmacy from CSV';

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
        // (new PharmacyImport)->import('pharmacy.csv', null, \Maatwebsite\Excel\Excel::CSV);
        Excel::import(new PharmacyImport, 'pharmacy.csv');
    }
}
