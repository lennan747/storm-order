<?php

namespace App\Jobs;

use App\Handlers\OrderLogistics;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateLogistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logistics = app(OrderLogistics::class)->logistics($this->order);
        //Log::info($logistics);
        if($logistics['State'] == 0)
        {
            DB::table('orders')->where('id',$this->order->id)->update(['ship_data' => json_encode($logistics)]);
        }

        if($logistics['State'] == 2)
        {
            DB::table('orders')->where('id',$this->order->id)->update([
                'ship_status' => 'delivered',
                'ship_data' => json_encode($logistics)
            ]);
        }
        if($logistics['State'] == 3)
        {
            DB::table('orders')->where('id',$this->order->id)->update([
                'ship_status' => 'received',
                'closed'      => true,
                'ship_data'   => json_encode($logistics)
            ]);
        }
    }
}
