<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer_Discount extends Model
{
    // use HasFactory;
    public $table='manufacture_discount';
    protected $fillable = ['manufacturer_id','users_id','discount'];
    public function users(){
        return $this->hasOne(User::class,'users_id');
    }
    public function manufacturer(){
        return $this->hasOne(Manufacturer::class,'manufacturer_id');
    }
}
