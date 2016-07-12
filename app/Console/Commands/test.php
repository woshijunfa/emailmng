<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Services\UserService;
use App\Services\CurlService;
use View;
use Log;
use Hash;

class test extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
     * @return mixed
     */
    public function handle()
    {
        var_dump(Hash::make('12345678'));
die;
        $email = ' sdf asdf';


        try 
        {
            $i = 1/0;
        } catch (\Exception $e) 
        {
            var_dump("insertemail_failed: $email  exception_message:" . $e->getMessage());
        }


        $e = "$email is not email skip";
        var_dump($e);

    }
}






