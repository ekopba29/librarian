<?php

namespace App\Http\Requests;

use App\Http\MyService\ResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegistrationUserRequest extends FormRequest
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
            'email' => 'required|unique:users|email',
            'name' => 'required',
            'password' => 'min:3|required',
        ];
    }

    public function passedValidation()
    {
        $dataValidation = $this->toArray();
        $dataValidation['password'] = Hash::make($this->password);
        $this->replace($dataValidation);
        $this->merge(['role' => 'user']);
    }

    public function failedValidation(Validator $validator)
    {
        return ResponseService::validationErrorStatus($validator);
    }

}
