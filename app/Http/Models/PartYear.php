<?php

namespace App\Http\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartYear extends Model
{
//    use HasFactory;
    public $table='part_years';
    protected $fillable = ['model_id','min_year','max_year','part_id'];
}
