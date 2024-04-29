<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "mod_2_company_tasks";
    protected $fillable = [
        'company_id','description','created_by','updated_by','created_at','updated_at',
    ];

}
