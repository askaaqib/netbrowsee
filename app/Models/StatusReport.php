<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
 
class StatusReport extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $with = [
        'usersName',
    ];
	protected $fillable = [
		//'id',
		'customer_id',
	    'subject',
	    'message',
	];

   	protected $table = 'contactus';
   	//  public function contactus()
    // {
    //     return $this->belongsToMany(ContactUs::class);
    // }

	public function usersName() {
        return $this->belongsTo(User::class,'customer_id',	'id' );
    }


}
