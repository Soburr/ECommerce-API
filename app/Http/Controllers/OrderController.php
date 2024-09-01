<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('user')->all();
        if ($orders) {
          return response()->json($orders, 200);
        } else {
          return response()->json('No Orders Found!');
        }
    }

    public function show ($id) {
        $order = Order::find($id);
        if ($order) {
         return response()->json($order, 200);
      } else {
         return response()->json('No Order Found!');
      }
     }

}
