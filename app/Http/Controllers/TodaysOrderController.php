<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TodaysOrderController extends Controller
{
    public function index()
    {
        $orders = Http::get('https://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/orders.json');

        $items = Http::acceptJson('application/json')
        ->get('https://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/items.json');

        $orders = $orders->json();
        $items = $items->json();


        $result = [];

        foreach($orders as $order){
            foreach($items as $key => $item){
                if($order['id'] === $item['orderId']){
                    $result = array_merge_recursive($order, $item);
                }
            }
        }


        return view('orders', compact($result));
    }

    private function mergeOrderAndItems($orders, $items)
    {
        echo $orders['id'];
        echo $items['orderId'];
    }
}
