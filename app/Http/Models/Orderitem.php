<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    // use HasFactory;
    public $table='orderitem';
    protected $fillable = ['order_id','part_id','quantity','is_delete'];
    public function parts()
    {
        return $this->belongsTo(Parts::class,'part_id');
    }
    
}
