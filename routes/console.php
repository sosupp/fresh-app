<?php

use App\Interview\Orders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/


Artisan::command('order:show', function () {

    $orders = Http::get('https://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/orders.json');
    $items = Http::get('https://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/items.json');
    $customers = Http::get('https://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/customers.json');


    $orders = $orders->json();
    $items = $items->json();
    $customers = $customers->json();


    function combineData($array, $array2, $array3)
    {
        $length = count($array);
        for ($i=0; $i < $length; $i++) {

            // joining customer data based on customer ID
            $array[$i]['customer'] = [];
            $IdOnOrder = $array[$i]['customerId'];

            $thisCustomer = array_values(array_filter($array2, function($value) use($IdOnOrder){
                return $value['id'] === $IdOnOrder;
            }));

            $array[$i]['customer'] = $thisCustomer;

            // joining order items data based on order ID
            $array[$i]['items'] = [];
            $orderId = $array[$i]['id'];

            $thisItems = array_values(array_filter($array3, function($value) use($orderId){
                return $value['orderId'] === $orderId;
            }));

            $array[$i]['items'] = $thisItems;
        }

        return $array;
    }


    // Call function to combine data
    $ordersToday = combineData($orders, $customers, $items);

    //Save each order data into an array
    $newOrder = [];

    foreach ($ordersToday as $key1 => $value1) {
        foreach($value1 as $key2 => $value2){

            if(is_array($value2)){
                foreach($value2 as $key3 => $value3){
                    $newOrder[] .=
                        $value1['id'] . ', ' .
                        $value1 ['createdAt'] . ', ' .
                        $value1['items'][$key3]['id'] . ', ' .
                        $value1['items'][$key3]['name'] . ', ' .
                        $value1['items'][$key3]['quantity'] . ', ' .
                        $value1['customer'][0]['firstName'] . ', ' .
                        $value1['customer'][0]['lastName'] . ', ' .
                        $value1['customer'][0]['addresses'][0]['address'] . ', ' .
                        $value1['customer'][0]['addresses'][0]['city'] . ', ' .
                        $value1['customer'][0]['addresses'][0]['zip'] . ', ' .
                        $value1['customer'][0]['email'] . ', ' ;
                }
            }
        }

    }

    // Generate CSV file with data
    $filename = 'today_orders.csv';
    $file = fopen($filename, 'w');

    if($file === false){
        return "Error opening the file " . $filename;
    }

    // writing heading first
    $csvHeading = [
        "orderID","orderDate",
        "orderItemID","orderItemName",
        "orderItemQuantity","customerFirstName",
        "customerLastName","customerAddress",
        "customerCity", "customerZipCode", "customerEmail \n",
    ];

    $csvHeading = implode(',', $csvHeading);
    file_put_contents($filename, $csvHeading);

    // Order data array to csv
    $formattedOrders = implode(PHP_EOL, $newOrder);
    file_put_contents($filename, $formattedOrders, FILE_APPEND);

    $this->info('CSV file for orders generated with the name ' . $filename);

})->purpose('Displays order for today with customers information');
