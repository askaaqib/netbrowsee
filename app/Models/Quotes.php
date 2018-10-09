<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Quotes.
 *
 * @property int                                                        $id
 * @property int|null                                                   $Quotes_num
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quotes published()
 * @mixin \Eloquent
 */

class Quotes extends Model
{
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'quotation_number',
        'quotation_name',        
        'quotation_description',
        'travelling_time',
        'travelling_km',
        'vat_amount',
        'net_amount',
        'total_amount',
        'labour_rates',
        'materials_rates',
        'vat_rates',
        'client_email',
        'project_id',
        'project_managers_id',
        'jobcard_id',
        'rows',
        'company_address',
        'company_logo',
        'bank_account',
        'quotation_digit'
    ];


    protected $table = 'quotes';

}
