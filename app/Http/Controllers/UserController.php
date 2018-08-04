<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Criteria\RequestCriteria;
use App\Http\Controllers\BaseController;
use App\Services\RolePermissionService;
use App\Services\LoginService;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;
use App\User;

class UserController extends BaseController
{
    /**
     * The User Repository Instance.
     *
     * @var App\Repositories\UserService
     */
    private $service;

    /**
     * Resolve an instance of the User Repository from the Container.
     * Set the default Middleware.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $users = $this->service->list(request());
        $this->authorize('list', User::class);

        if (request()->wantsJson()) {
            return response()->json([
                'draw' => request()->draw,
                'data' => $users
                ]);
        }

        return view('users.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $user = $this->service->create();
        $this->authorize('create', $user);
        return view('users.create', compact('user'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  App\Http\Requests\UserRequest  $request
    * @return \Illuminate\Http\Response
    */
    public function store(UserRequest $request)
    {
        $saved = $this->service->store($request);
        if ($saved) {
            return redirect()->route($this->prefix.'users.index');
        }
        return redirect()->back()->withErrors($e->getMessage());
    }

    /**
    * Display the specified resource.
    *
    * @param  integer $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $user = $this->service->show($id);
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  integer  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $user = $this->service->edit($id);
        $this->authorize('edit', $user);
        return view('users.edit', compact('user'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  App\Http\Requests\UserRequest  $request
    * @param  integer  $id
    * @return \Illuminate\Http\Response
    */
    public function update(UserRequest $request, $id, $method = null)
    {
        $this->service->update($request, $id, $method);
        return redirect()->back();
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  integer  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $user = $this->service->delete($id);
        return redirect()->back();
    }
}
