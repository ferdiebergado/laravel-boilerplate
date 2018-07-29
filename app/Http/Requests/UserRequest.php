<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Policies\UsersPolicy;

class UserRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return new UsersPolicy;
    }
    
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|string|max:150',
                    'email' => 'required|string|max:150|email|unique:users,email',
                    'password' => 'required|confirmed|string|max:150'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:150',
                    'email' => 'required|string|max:150|email|unique:users,email,' . $this->route()->parameters['id'],
                    'old_password' => [
                        'nullable',
                        'string',
                        'max:150',
                        'required_with:password',
                        function ($attribute, $value, $fail) {
                            if (!empty($value)) {
                                if (!\Illuminate\Support\Facades\Hash::check($value, \App\User::findOrFail($this->route()->parameters['id'])->password)) {
                                    return $fail('Password does not match.');
                                }
                            }
                        },
                    ],
                    'password' => 'sometimes|required_with:old_password|confirmed|string|max:150|nullable'
                ];
            }
            default:
            break;
        }
    }
}
