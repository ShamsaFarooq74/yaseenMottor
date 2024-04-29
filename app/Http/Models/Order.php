<?php

namespace App\Http\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // use HasFactory;
    public $table='order';
    protected $fillable = ['user_id','pay_id','status','is_delete'];
    public function category()
    {
        return $this->belongto(category::class);
    }
    public function orderitem()
    {
        return $this->hasmany(Orderitem::class,'order_id','id');
    }
  
}
