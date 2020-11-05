<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('create-staff');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'email' => 'required|email',
            'phone' => 'required',
            'type' => 'required|in:Essential,Backup',
            'position' => 'required|max:191',
            'skills' => 'required',
            'qualifications' => 'required',
            'wsp_id' => 'required|numeric|in:' . auth()->user()->wsps()->first()->id,
        ];
    }
}
