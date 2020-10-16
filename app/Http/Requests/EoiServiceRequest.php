<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EoiServiceRequest extends FormRequest
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
            'services.*.areas' => 'required',
            'services.*.total' => 'required|numeric',
        ];
    }
}
