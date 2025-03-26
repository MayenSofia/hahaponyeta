<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model {
    use HasFactory;
    protected $fillable = ['order_id', 'checked_out_at'];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
