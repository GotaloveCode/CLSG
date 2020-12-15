<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ErpAttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('create_erp');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display_name' => 'required|max:191',
            'document_type' => 'required|max:191',
            'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,docx,doc,xls,xlsx,csv'
        ];
    }
}
