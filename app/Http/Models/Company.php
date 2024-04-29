<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    // use HasFactory;
    public $table="companydetail";
    protected $fillable =['name','image','is_delete','is_active'];
    public function user()
        {
            return $this->hasOne(User::class,'user_id','id');
        }
}
