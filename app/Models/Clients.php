<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Clients extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			"first_name",
			"last_name",
			"business_name",
			"email",
			"street",
			"town",
			"region",
			"postcode",
			"primary_phone",
			"secondary_phone",
			"notes",
	];

   	protected $table = 'clients';
}