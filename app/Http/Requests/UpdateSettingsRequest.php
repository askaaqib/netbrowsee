<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'company_name'   => 'required',            
            'company_address'        => 'required',            
            'bank_account'      => 'required',            
            'quote_ref_start'        => 'required|integer|min:1|digits_between: 0,9',            
            'quote_vat' => 'required',
            'invoice_ref_start' => 'required|integer|min:1|digits_between: 0,9'        
        ];
    }
}
