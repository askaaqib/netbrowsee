<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotesRequest extends FormRequest
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
            'quotation_number'          =>        'required',
            'quotation_name'         =>        'required',
            'travelling_time'     =>        'required',
            'travelling_km'       =>        'required',
            'vat_amount'          =>        'required',
            'net_amount'          =>        'required',
            'total_amount'        =>        'required'
        ];
    }
}
