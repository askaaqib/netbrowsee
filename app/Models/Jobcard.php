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

    protected $with = [
        'quotes',
        'get_assigned_user',
        'get_project_manager'
    ];
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jobcard_num',
        'description',
        'problem_type',
        'priority',
        'facility_name',
        'district',
        'sub_district',
        'travelling_paid',
        'status',
        'contractor_id',
        'before_pictures',
        'during_pictures',
        'after_pictures',
        'projects_id',
        'projectmanager_id',
        'attachment_receipt',
        'labour_paid',
        'materials_paid',
        'vat_rate',
    ];

    protected $table = 'jobcard';

    public function quotes()
    {
        return $this->belongsTo(Quotes::class);
    }

    public function get_project_manager() {
        return $this->belongsTo(User::class, 'projectmanager_id');
    }

    public function get_assigned_user() {
        return $this->belongsTo(User::class, 'contractor_id');
    }
    const DRAFT = 0;
    const PENDING = 1;
    const PUBLISHED = 2;
}
