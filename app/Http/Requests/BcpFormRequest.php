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
            'introduction' => 'required',
            'planning_assumptions' => 'required',
            'training' => 'required',
            'staff_health_protection' => 'required',
            'supply_chain' => 'required',
            'emergency_response_plan' => 'required',
            'communication_plan' => 'required',
            'government_subsidy' => 'numeric',
            'projected_revenues.*.month' => 'required|numeric|between:1,12',
            'projected_revenues.*.year' => 'required|numeric|min:2020',
            'projected_revenues.*.amount' => 'required|numeric|min:1',
            'essential_operations.*.priority_level' => 'required|numeric',
            'essential_operations.*.backup_staff' => 'required|numeric',
            'essential_operations.*.primary_staff' => 'required|numeric',
            'essential_operations.*.essentialfunction_id' => 'required|numeric',
            'bcp_teams.*.name'=> 'required|max:191',
            'bcp_teams.*.unit'=> 'required|max:191',
            'bcp_teams.*.role'=> 'required|max:191',
            'wsp_id' => 'required|numeric|in:' . auth()->user()->wsps()->first()->id,
        ];
    }

}
