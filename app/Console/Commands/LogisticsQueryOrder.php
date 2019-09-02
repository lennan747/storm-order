<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\OrdersLogistics;

class LogisticsQueryOrder extends Command
{
    use OrdersLogistics;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:logistics-query-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '查询订单物流信息';

    /**
     * Create a new command instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        parent::__construct();
//    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        // 在命令行打印一行信息
        $this->info("开始获取...");

        $this->logisticsQuery();

        $this->info("成功获取！");
    }
}
