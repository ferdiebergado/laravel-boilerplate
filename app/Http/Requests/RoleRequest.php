<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Policies\RolesPolicy;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return new RolesPolicy;
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
                        'name' => 'required|string|max:50|unique:roles,name',
                        'slug' => 'required|string|max:50|unique:roles,slug'
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name' => 'required|string|max:50|unique:roles,name,'.$this->route()->parameters['id'],
                        'slug' => 'required|string|max:50|unique:roles,name,'.$this->route()->parameters['id']
                    ];
                }
            default:
                break;
        }
    }
}
