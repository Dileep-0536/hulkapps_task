<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUploadFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** validation for adding upload form */
        return [
            'document_name' => 'required|mimes:pdf|max:20000',
            'tags'=> 'required|array',
            'tags.*' => 'required'
        ];
    }

    public function messages()
    {
      return [            
        'document_name.required' => "You must use the 'Choose file' button to select pdf file you wish to upload",
        'document_name.max' => "Maximum file size to upload is 20MB (20000 KB).",
        'tags.*.required' => "Select atleast one tag"
      ];
    }
}
