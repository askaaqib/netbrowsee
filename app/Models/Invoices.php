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
			"invoice_number",
			"invoice_digit",
			"invoice_name",
			"vat_amount",
			"net_amount",
			"total_amount",
			"vat_rates",
			//"jobcard_id",
			"project_id",
			//"project_managers_id",
			"client_email",
			"invoice_description",
			"rows",
			"bank_account" ,
			"company_address",
			"company_logo",
			"invoice_status",
			"client_id",
	        "client_name",
	        "client_business",
	        "client_street",
	        "client_town",
	        "client_region",
	        "client_postcode", 
	];

   	protected $table = 'invoices';
}