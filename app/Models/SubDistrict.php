<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SubDistrict extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $with = [
        'district',
    ];
    protected $fillable = [
	    	'name'  ,
	    	'district_id'         
            
	];

   	protected $table = 'subdistrict';
   	public function district()
    {
        return $this->belongsTo(District::class);
    }
}
