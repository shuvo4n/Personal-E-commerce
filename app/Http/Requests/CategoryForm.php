<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FindOutNumberRule;

class CategoryForm extends FormRequest
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
        return [
            //
            'category_name' => [ 'required', 'unique:categories,category_name', new FindOutNumberRule],
            //'category_name' => 'required|unique:categories,category_name',
            'category_description' => 'required'
        ];
    }
    public function messages()
    {
        return [
            //
            'category_name.required' =>  'Nam koi?',
            'category_description.required' => 'Description koi?',
            'category_name.alpha' =>  'Number Likha jabe nah',
            'category_description.alpha' => 'Number Likha jabe nah'
        ];
    }
}
