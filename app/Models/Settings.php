<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Settings extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    	'company_name',            
            'company_address',            
            'company_logo',            
            'bank_account',            
            'quote_ref_start',            
            'quote_vat', 
	];

   	protected $table = 'settings';
}
