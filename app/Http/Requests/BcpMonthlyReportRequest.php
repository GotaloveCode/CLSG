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
            'revenue' => 'required|numeric',
            'operations_costs' => 'required|numeric',
            'clsg_total' => 'required|numeric',
            'challenges' => 'required',
            'expected_activities' => 'required',
            'essential' => 'required',
            'customer' => 'required',
            'staff' => 'required',
            'communication' => 'required'
        ];
    }
}
