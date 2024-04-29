<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    // use HasFactory;
    public $table='payments';
    protected $fillable = ['paymethod_id','date','amount','image','is_deleted'];
    public function make()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentmethod()
    {
        return $this->belongsTo(paymentmethod::class);
    }
}
