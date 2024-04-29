<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_el extends Model
{
    // use HasFactory;
    public $table='model';
    protected $fillable = ['make_id','model_name','model_code','company_name','image','is_active','is_delete'];
    public function make()
    {
        return $this->belongsTo(make::class);
    }
    public function modelyear()
    {
        return $this->hasmany(modelyear::class,'cat_id');
    }

}
