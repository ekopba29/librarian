<?php

namespace App\Http\Requests;

use App\Http\MyService\ResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ManageBookRequest extends FormRequest
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
        
        return [
            'judul' => request()->getUri() == route('insider.books.store') ? 'required|unique:books,judul' : 'required|unique:books,judul,'.request()->route('book'),
            'deskripsi' => 'required',
            'stock' => 'required|numeric',
            'category' => 'required',
            'pengarang' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return ResponseService::validationErrorStatus($validator);
    }
}
