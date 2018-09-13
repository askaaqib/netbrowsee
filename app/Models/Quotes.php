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
        'travelling_time',
        'travelling_km',
        'vat_amount',
        'net_amount',
        'total_amount',
        'client_id', 
        
        'labour_rates_id',
        'materials_rates_id',
        'vat_id'
    ];


    protected $table = 'quotes';

}
