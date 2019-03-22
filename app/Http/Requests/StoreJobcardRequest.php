<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $request)
    {
        // if($request->jobcard_num){
        //     return [
        //         'jobcard_num' => 'required',
        //         'problem_type' => 'required',
        //         'description' => 'required',
        //         'priority' => 'required',
        //         'facility_name' => 'required',
        //         //'district' => 'required',
        //         'sub_district' => 'required',
        //         'projects_id' => 'required',
        //         //'labour_rates_id' => 'required',
        //         //'materials_rates_id' => 'required',
        //         'travelling_paid' => 'required',
        //        // 'quoted_amount' => 'required|numeric',
        //         'status' => 'required',
        //         'contractor_id' => 'required',
        //        'before_pictures' => 'required',
        //       //  'during_pictures' => 'required',
        //        'after_pictures' => 'required',
        //     ];
        // } 


        if($request->status === "1"){
            return[

               'labour_paid' => 'required|numeric',
                // 'materials_paid' => 'required|numeric',
                //'materials_rates_id' => 'required',
                //'travelling_paid' => 'required',
                'jobcard_num'          => 'required',
                 //'problem_type' => 'required',
                'description' => 'required',
            ];
        }
        return [
            'jobcard_num'          => 'required',
             //'problem_type' => 'required',
            'description' => 'required',
            // 'priority' => 'required',
             //'facility_name' => 'required',
            // 'district' => 'required',
            // 'sub_district' => 'required',
            // 'projects_id' => 'required',
            // 'labour_rates_id' => 'required',
            // 'materials_rates_id' => 'required',
            // 'travelling_paid' => 'required',
            // 'quoted_amount' => 'required',
            // 'status' => 'required',
            // 'contractor_id' => 'required',
            // 'before_pictures' => 'required',
            // 'during_pictures' => 'required',
            // 'after_pictures' => 'required',
        ];
    }
}
