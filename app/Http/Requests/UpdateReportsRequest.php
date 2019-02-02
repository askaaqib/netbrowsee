<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportsRequest extends FormRequest
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
            'description'   => 'required',            
            'status'        => 'required',            
            'expenses'      => 'required',            
            'amount'        => 'required',            
            'vat_collected' => 'required',            
            'profit_loss'   => 'required',            
        ];
    }
}
