<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $table = "mod_2_company_assets";
   protected $fillable = [
       'asset_status'
   ];

//    public function trackings()
//    {
//        return $this->hasMany(CompanyProducts::class, 'company_id');
//    }
}
