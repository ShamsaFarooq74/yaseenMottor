<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // use HasFactory;
    public $table='category';
    protected $fillable = ['category_name','image','is_active','is_delete'];
    public function parts()
    {
        return $this->hasmany(parts::class,'cat_id');
    }
    public function cart()
    {
        return $this->hasmany(cart::class,'cat_id');
    }
    public function modelyear()
    {
        return $this->belongto(modelyear::class);
    }
}
