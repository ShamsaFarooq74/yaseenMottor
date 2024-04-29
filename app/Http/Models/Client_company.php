<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Client_company extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "mod_2_company_client";
    protected $fillable = [
        'company_name','email','phone','website','city','address','created_by','updated_by','created_at','updated_at',
    ];

}
