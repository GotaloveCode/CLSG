<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonthlyVerificationRequest extends FormRequest
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
            'performance_score_details' => 'required',
            'clsg_details' => 'required',
            'recommendations' => 'required',
            'verification_team' => 'required',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|in:'.now()->year,
        ];
    }
}
