<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Services\EmailSerivce;
use View;
use Log;

class importEmail extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import_email {path} {tag?}';

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
        //获取路径
        $path = $this->argument('path');
        if (!is_file($path)) 
        {
            var_dump("not a file");
            return;
        }

        $tag = $this->argument('tag');
        $tag = empty($tag) ? '' : $tag;

        //获取文件
        $handle = @fopen($path, "r");
        if ($handle) 
        {
            while (!feof($handle)) 
            {
                $buffer = fgets($handle, 4096);
                if (!empty($buffer)) 
                {
                    var_dump($buffer);
                    EmailSerivce::insertMail($buffer,$tag);
                }
            }
            fclose($handle);
        }
    }
}






