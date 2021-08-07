<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'student_name' => 'required|max:255',
            'grade' => 'required|max:5',
            'date_of_birth' => 'required',
            'photo' => 'mimes:jpeg,png,jpg',
            'country' => 'required|in:1,2,3',
            'address' => 'required|max:255',
            'city' => 'required|max:100'
        ];
    }
}
