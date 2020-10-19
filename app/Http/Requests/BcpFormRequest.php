<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BcpFormRequest extends FormRequest
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
            'executive_summary' => 'required',
            'rationale' => 'required',
            'environment_analysis' => 'required',
            'company_overview' => 'required',
            'financing' => 'required',
            'strategic_direction' => 'required',
            'objectives' => 'required|array',
            'operation_costs' => 'required|array'
        ];
    }

}
