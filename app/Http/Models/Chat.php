<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
   protected $table = 'chat';
    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'message'
    ];
}
