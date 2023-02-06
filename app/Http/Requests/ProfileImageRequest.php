<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileImageRequest extends FormRequest
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
        return ['image' => [
                 'required', 
                 'file',
                 'image',
                 'mimes:jpeg,png', 
                 'dimensions:max_width=1000, min_width=50, max_height=1000, min_height=50',
                 'max:200'
              ],
        ];
    }
}
