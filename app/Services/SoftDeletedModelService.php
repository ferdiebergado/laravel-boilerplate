<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class SoftDeletedModelService
{
    public static function handle(Model $model, $method)
    {
        if ($method === 'restore') {
            $model->restore();
        }
        if ($method === 'delete') {
            $model->forceDelete();
        }
        session()->flash('status', title_case($method.'d'));
    }
}
