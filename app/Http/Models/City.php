<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $table='cities';
    protected $fillable = ['city_name','country_id','is_active','is_delete'];
}
