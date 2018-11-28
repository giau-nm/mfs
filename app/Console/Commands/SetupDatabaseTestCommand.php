<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use PDO;
use PDOException;
use Illuminate\Support\Facades\DB;

class SetupDatabaseTestCommand extends Command
{
    const DBTEST = 'dockerAppTest';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup database';

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
     * @return mixed
     */
    public function handle()
    {
        // Checking database test
        $connection = $this->hasArgument('connection') && $this->argument('connection') ? $this->argument('connection'): DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);
        $hasDb = DB::connection($connection)->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "."'". self::DBTEST ."'");

        // Create database
        if (empty($hasDb)) {
            Artisan::call('db:create', array('dbname' => self::DBTEST));
        }

        Artisan::call('migrate:refresh', array('--seed' => true, '--database' => 'testing'));
        $this->info("Database has been refresh");
    }
}
