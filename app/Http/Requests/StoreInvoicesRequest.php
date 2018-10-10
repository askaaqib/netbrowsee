<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoicesRequest extends FormRequest
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
            'jobcard_id' => 'required'
            // 'description' => 'required',
            // 'quantity' => 'required',
            // 'amount' => 'required',
            // 'net_amount' => 'required',
            // 'vat_amount' => 'required',
            // 'total_amount' => 'required',             
            // 'vat_id' => 'required',             
            // 'materials_rates_id' => 'required',             
            // 'quotations_id' => 'required',             
        ];
    }
}
