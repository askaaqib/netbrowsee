<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Reports extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    	'description',            
            'status',            
            'expenses',            
            'amount',            
            'vat_collected',            
            'profit_loss', 
            'jobcard_id',
	];

   	protected $table = 'reports';
}
