<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "mod_2_company_notes";
    protected $fillable = [
        'company_id','description','created_by','updated_by','created_at','updated_at',
    ];

}
