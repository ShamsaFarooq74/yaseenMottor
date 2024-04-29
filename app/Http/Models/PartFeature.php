<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartFeature extends Model
{
    use HasFactory;
    protected $table='part_features';

    public function features() {
        return $this->hasOne(Feature::class,'id','feature_id');    
    }

}
