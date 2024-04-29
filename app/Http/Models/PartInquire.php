<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartInquire extends Model
{
    use HasFactory;
    protected $table = 'part_inquires';
    
     public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
      }
    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
      }
    public function part(){
        return $this->belongsTo(PartDetails::class,'part_id','id');
      }
}
