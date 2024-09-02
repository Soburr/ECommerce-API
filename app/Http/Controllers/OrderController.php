<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('user')->all();
        if ($orders) {

            foreach($orders as $order) {
               foreach($order->items as $order_items) {
                   $product = Product::where('id', $order_items->product_id)->pluck('name');
                   $order_items->product_name = $product['0'];
               }
            }

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

     public function store(Request $request) {
        try {
         $location = Location::where('user_id', Auth::id())->first();

         $request->validate([
            'order_items' => 'required',
            'total_price' => 'required',
            'out_of_delivery' => 'required',
            'quantity' => 'required'
         ]);

         $order = new Order();
         $order->user_id = Auth::id();
         $order->location_id = $location->id;
         $order->total_price = $request->total_price;
         $order->out_of_delivery = $request->out_of_delivery;

         $order->save();

         foreach($request->order_items as $order_items) {
            $items = new OrderItems();
            $items->order_id = $order->id;
            $items->price = $order_items['price'];
            $items->product_id = $order_items['product_id'];
            $items->quantity = $order_items['quantity'];

            $items->save();

            $product = Product::where('id', $order_items['product_id'])->first();
            $items->quantity = $order_items['quantity'];
            $items->save();
         }

         return response()->json('Order is added', 201);
     } catch(Exception $e) {
         return response()->json($e);
    }
    }

    public function get_order_items($id ) {
         $order_items = OrderItems::where('order_id', $id)->get();

         if ($order_items) {
            foreach($order_items as $order_item) {
                $product = Product::where('id', $order_item->product_id)->pluck('name');
                $order_item->product_name = $product['0'];
            }

            return response()->json($order_items, 200);
         } else {
            return response()->json('No Items Found!');
         }
    }

    public function get_user_orders($id){
        $orders = Order::where('user_id', $id)::with('items', function($query) {
            $query->orderBy('created_at', 'desc');
        })->get();

        if ($orders) {
            foreach($orders->items as $order) {
                $product = Product::where('id', $order->product_id)->pluck('name');
                $order->product_name = $product['0'];
            }

            return response()->json($orders, 200);
         } else {
            return response()->json('No Orders Found For This User!');
         }
    }

    public function change_order_status($id, Request $request) {
         $order = Order::find($id);

         if ($order) {
            $order->update(['status'=>$request->status]);
            return response()->json('Status Changed Successfully');
         } else {
            return response()->json('Order was not found!');
         }
    }
}
