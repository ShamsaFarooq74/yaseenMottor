<?php

namespace App\Http\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parts extends Model
{
    // use HasFactory;
    protected $table='parts';
    protected $fillable = ['cat_id','ref_no','image','description','price','is_delete'];
//    public function category()
//    {
//        return $this->belongsTo(Category::class);
//    }
    // public function orderitem()
    // {
    //     return $this->hasone(orderitem::class,'part_id','id');
    // }
    
    public function trendingpart()
    {
        return $this->hasOne(TrendingParts::class,'id');
    }

    public function part_features() {
        return $this->hasMany(PartFeature::class,'id','part_id');    
    }
}
