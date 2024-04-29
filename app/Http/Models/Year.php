<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    public $table='year';
    protected $fillable = ['year'];
    public function modelyear()
    {
        return $this->hasmany(modelyear::class,'min_year','max_year');
    }
}
