<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Services\UserService;
use App\Services\CurlService;
use App\Services\CommonService;
use App\Models\Dict;
use App\Models\Email;
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
        $result = Email::insertMail("u3002410025473@qq.com",'tieba');
        var_dump($result);die;
        die;
        $result = gGetQQEmail("ud0988888@qq.com");

        var_dump($result);die;
        $result = Dict::getBegin(1);
        var_dump($result);
    }
}






