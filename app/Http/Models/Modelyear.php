<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelyear extends Model
{
    // use HasFactory;
    public $table='part_years';
    protected $fillable = ['model_id','min_year','max_year','part_id'];
//    public function mod_el()
//    {
//        return $this->belongto(mod_el::class,'model_id');
//    }
//    public function year()
//    {
//        return $this->belongto(year::class);
//    }
//    public function categories()
//    {
//        return $this->hasmany(category::class,'id','part_id');
//    }
}
