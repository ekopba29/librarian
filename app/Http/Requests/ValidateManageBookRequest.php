<?php

namespace App\Http\Requests;

use App\Http\MyService\ResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ValidateManageBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'judul' => 'required|unique:books,judul',
            'deskripsi' => 'required',
            'stock' => 'required',
            'category' => 'required',
            'pengarang' => 'required'
        ];

        if (request()->path() != route('adm.books.create')) {
            $rule['judul'] = 'required';
        }
    }

    public function failedValidation(Validator $validator)
    {
        return ResponseService::validationErrorStatus($validator);
    }
}
