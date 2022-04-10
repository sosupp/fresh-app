<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays order for today with customers information';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $newOrder = ['1', 2, 'boy'];
        // $formattedOrders = implode(PHP_EOL, $newOrder);
        // $filename = 'orders.csv';
        // $file = fopen($filename, 'w');
        file_put_contents('new_orders.csv', "Hellow");

        // if($file === false){
        //     return "Error opening the file " . $filename;
        // }

        $this->info('Order details will be displayed soon');
    }
}
