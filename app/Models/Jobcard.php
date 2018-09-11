<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Jobcard.
 *
 * @property int                                                        $id
 * @property int|null                                                   $jobcard_num
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jobcard published()
 * @mixin \Eloquent
 */

class Jobcard extends Model
{
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jobcard_num',
    ];

    //protected $table = 'jobcard';

    const DRAFT = 0;
    const PENDING = 1;
    const PUBLISHED = 2;
}
