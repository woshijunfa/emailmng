<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Services\EmailSerivce;
use App\Models\PiciLog;
use View;
use Log;

class sendEmail extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_email';

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
        $pics = PiciLog::where('status','sending')->get();

        // var_dump($pics);die;
        foreach ($pics as $pic) 
        {
            EmailSerivce::sendPiciEmail($pic);
        }
    }
}






