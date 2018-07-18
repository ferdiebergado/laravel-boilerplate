<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\PermissionRequest;
use App\Policies\PermissionsPolicy;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return new PermissionsPolicy;
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
                        'name' => 'required|string|max:50|unique:permissions,name',
                        'slug' => 'required|string|max:50|unique:permissions,slug'
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name' => 'required|string|max:50|unique:permissions,name,'.$this->route()->parameters['id'],
                        'slug' => 'required|string|max:50|unique:permissions,name,'.$this->route()->parameters['id']
                    ];
                }
            default:
                break;
        }
    }
}
