<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

abstract class BaseController extends Controller
{
    protected $prefix = 'admin.';

    public function isAdminRequest()
    {
        return Route::is($this->prefix.'*');
    }

    public function getPrefix()
    {
        return $this->isAdminRequest() ?: $this->prefix;
    }
}
