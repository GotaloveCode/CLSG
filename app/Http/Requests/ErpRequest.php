<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ErpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('create-erp');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coordinator' => 'required|max:191',
            'wsp_id' => 'required|numeric|in:' . auth()->user()->wsps()->first()->id,
            'items.*.other' => 'required',
            'items.*.emergency_intervention' => 'required|max:191',
            'items.*.risks' => 'required',
            'items.*.mitigation.*' => 'required',
            'items.*.cost' => 'required|numeric',
        ];
    }
}
