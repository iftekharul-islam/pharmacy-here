<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class FreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fresh:all {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh all database';

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
	    
		$this->drop_tables();
	
	    Artisan::call('module:migrate Auth');
	    Artisan::call('module:migrate User');
	    Artisan::call('module:migrate Locations');
	    Artisan::call('module:migrate Products');
	    Artisan::call('module:migrate Orders');
	
	
	    $seed = $this->option('seed');
	    
	    if ($seed) {
		    $this->run_seeder();
	    }
    }
	
	/**
	 * Drop all tables
	 */
    public function drop_tables() {
	    $col_name = 'Tables_in_' . env('DB_DATABASE');
	
	    $tables = DB::select('SHOW TABLES');
	
	    $drop_list = [];
	
	    foreach($tables as $table) {
		
		    $drop_list[] = $table->$col_name;
		
	    }
	    
	    if ($drop_list) {
		    $drop_list = implode( ',', $drop_list );
		    DB::beginTransaction();
		    DB::statement( 'SET FOREIGN_KEY_CHECKS = 0' );
		    DB::statement( "DROP TABLE $drop_list" );
		    DB::statement( 'SET FOREIGN_KEY_CHECKS = 1' );
		    DB::commit();
	    }
    }
	
	/**
	 * Run seeder
	 */
    public function run_seeder() {
	    Artisan::call('module:seed User');
	    Artisan::call('module:seed Locations');
	    Artisan::call('module:seed Products');
	    Artisan::call('module:seed Orders');
    }
}
