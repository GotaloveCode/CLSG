<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BcpMonthlyReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-bcp');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'essential' => 'required',
            'customer' => 'required',
            'staff' => 'required',
            'communication' => 'required',
            'bcp_id' => 'required|numeric|exists:bcps,id',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|in:' . now()->year,
        ];
    }
}
