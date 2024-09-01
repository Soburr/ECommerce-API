<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity', 'price', 'order_id', 'product_id'
    ];

    public function order() {
        $this->belongsTo(Order::class, 'order_id');
    }

    public function product() {
        $this->belongsTo(Product::class, 'product_id');
    }
}
