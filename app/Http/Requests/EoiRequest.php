<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EoiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('create-eoi');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "program_manager" => 'required|max:191',
            "fixed_grant" => 'required|numeric',
            "variable_grant" => 'required|numeric',
            "emergency_intervention" => 'required|numeric',
            "operation_costs" => 'required|numeric',
            "water_service_areas" => 'required|string|max:500',
            "total_people_water_served" => 'required|numeric',
            "proportion_served" => 'required|numeric'
        ];
    }
}
