<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking_image extends Model
{
    protected $table = "mod_3_tracking_file";
    protected $fillable = [
        'tracking_id','file', 'updated_by', 'file_type',
        'created_by' ,'created_at','updated_at'
    ];

//    public function trackings()
//    {
//        return $this->hasMany(CompanyProducts::class, 'company_id');
//    }
}
