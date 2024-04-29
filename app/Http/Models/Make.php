<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    // use HasFactory;
    public $table="make";
    protected $fillable =['company_name','logo','is_delete','is_active'];
    public function model()
        {
            return $this->hasMany(Mod_el::class,'make_id','id');
        }
}
