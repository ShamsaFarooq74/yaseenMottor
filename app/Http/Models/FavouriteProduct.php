<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteProduct extends Model
{
    protected $table = 'favourite_products';
    protected $fillable = [
        'id','product_id','user_id' ];
}
