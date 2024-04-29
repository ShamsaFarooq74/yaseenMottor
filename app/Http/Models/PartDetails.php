<?php

namespace App\Http\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartDetails extends Model
{
//    use HasFactory;
    protected $table='parts';
    protected $fillable = ['manufacturer','currency_id','model_id','city_id','make_id','cat_id','ref_no','image','description','price','is_delete'];
   
    public function make(){
        return $this->belongsTo(Make::class,'make_id','id');
      }
    public function model(){
        return $this->belongsTo(Mod_el::class,'model_id','id');
      }
    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
      }
    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
      }
    public function fuel(){
        return $this->belongsTo(FuelType::class,'fuel_id','id');
      }
    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id','id');
      }
}
