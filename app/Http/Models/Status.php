<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "mod_status";
//    protected $fillable = [
//        'company_name','owner_name','phone','website_url','email','updated_by',
//        'is_blocked','lat','long','address','description','image','created_by','status','created_at','updated_at'
//    ];

//    public function trackings()
//    {
//        return $this->hasMany(CompanyProducts::class, 'company_id');
//    }
}
