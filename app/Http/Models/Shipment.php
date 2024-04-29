<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    public $table='shipments';

     public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
      }
       public function port(){
        return $this->belongsTo(Port::class,'port_id','id');
      }
    
}
