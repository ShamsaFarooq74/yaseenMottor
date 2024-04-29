<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendingParts extends Model
{
    //use HasFactory;
    public $table='trending_parts';
    protected $fillable = ['part_id','start_date','end_date'];

    public function part()
    {
        return $this->belongsTo(Parts::class,'part_id');
    }
    public function partDetails()
    {
        return $this->belongsTo(PartDetails::class,'part_id','id')->where('is_delete', 'N')->where('is_active', '1');
    }
}
