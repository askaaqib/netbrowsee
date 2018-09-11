<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobcardRequest extends FormRequest
{
    /**
     * Determine if the meta is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jobcard_num'          => 'required',
            // 'problem_type' => 'required',
            // 'description' => 'required',
            // 'priority' => 'required',
            // 'facility_name' => 'required',
            // 'district' => 'required',
            // 'sub_district' => 'required',
            // 'project_manager' => 'required',
            // 'labour_paid' => 'required',
            // 'materials_paid' => 'required',
            // 'travelling_paid' => 'required',
            // 'quoted_amount' => 'required',
            // 'status' => 'required',
            // 'assigned_to' => 'required',
            // 'before_pictures' => 'required',
            // 'during_after_pictures' => 'required',
        ];
    }
}
