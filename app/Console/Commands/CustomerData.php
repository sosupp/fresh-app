<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CustomerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a list or orders with customer information';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $response = Http::get('https://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/items.json');

        return $response;
    }
}
