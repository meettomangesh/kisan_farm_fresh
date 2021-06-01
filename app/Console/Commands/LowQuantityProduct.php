<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class LowQuantityProduct extends Command
{
    use Dispatchable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lowquantityproduct';

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
        $startTime = date('Y-m-d H:i:s');
        $this->comment(PHP_EOL . "lowquantityproduct started at :" . $startTime . PHP_EOL);

        $productData = $this->getLowQuantityProduct();
        foreach($productData as $key) {
            // $key->mobile_number;
        }
        
        $endTime = date('Y-m-d H:i:s');
        $this->comment(PHP_EOL . "lowquantityproduct ended at :" . $endTime . PHP_EOL);
        Log::info('command lowquantityproduct Call.', ['startTime' => $startTime, 'endTime' => $endTime, 'comment' => '']);
    }

    /**
     * This function is used to get all the customer whose birthday in current month
     * @return array $response
     */
    public function getLowQuantityProduct()
    {
        $response = DB::select('call getLowQuantityProduct()');
        return $response;
    }
}
