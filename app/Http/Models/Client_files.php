<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Client_files extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "mod_2_company_files";
    protected $fillable = [
        'company_id','file_name','created_by','updated_by','created_at','updated_at',
    ];

}
