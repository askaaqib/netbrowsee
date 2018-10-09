<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Invoices extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    	'description',
            'quantity',
            'amount',
            'net_amount',
            'vat_amount',
            'total_amount',
            'vat_id',
            'materials_rates_id',
            'quotations_id',
	];

   	protected $table = 'invoices';
}
