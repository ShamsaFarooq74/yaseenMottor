<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Paymentmethod extends Model
{
    // use HasFactory;
    public $table='paymentmethod';
    protected $fillable = ['method','is_active'];
    public function payments()
    {
        return $this->hasmany(payments::class,'paymethod_id','id');
    }
}
