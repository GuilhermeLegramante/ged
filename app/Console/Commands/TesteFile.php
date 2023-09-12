<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class TesteFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste';

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
        File::append(
            storage_path('/logs/teste.log'),
            '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL
        );
    }
}
