<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MgmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role('wasreb');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mgms.*.amount' => 'required|numeric',
            'mgms.*.month' => 'required|numeric',
            'mgms.*.year' => 'required|numeric',
        ];
    }
}
