<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = "mod_3_tracking";
    protected $fillable = [
        'company_id','user_id','night_view','light_working','tracking_date',
        'status_id','asset_id',
        'updated_by',
        'created_by','created_at','updated_at'
    ];

//    public function trackings()
//    {
//        return $this->hasMany(CompanyProducts::class, 'company_id');
//    }
}
