<?php

namespace App\Http\Controllers;

use App\Repositories\LoginRepository;
use App\Criteria\RequestCriteria;

class LoginController extends Controller
{
    private $login;

    public function __construct(LoginRepository $login)
    {
        $this->middleware('auth');
        $this->login = $login;
    }

    public function index()
    {
        // Fetch paginated list of logins based on parameters from the Request (sent by datatables).
        $logins = $this->login->getByCriteria(new RequestCriteria(request()))->latest()->paginate(request()->length);

        // Send the response as JSON.
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => request()->draw,
                'data' => $logins->toArray()
            ]);
        }

        return view('logins.index');
    }
}
