<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Criteria\RequestCriteria;
use App\Interfaces\UserRepositoryInterface as UserRepository;
use App\Http\Controllers\BaseController;
use App\Services\RolePermissionService;
use App\Services\LoginService;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    /**
     * The User Repository Instance.
     *
     * @var App\Repositories\UserRepository
     */
    private $user;

    /**
     * Resolve an instance of the User Repository from the Container.
     * Set the default Middleware.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // Fetch paginated list of Users based on parameters from the Request (sent by datatables).
        $users = $this->user->getByCriteria(new RequestCriteria(request()))->paginate(request()->length);

        // Send the response as JSON.
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => request()->draw,
                'data' => $users
                ]);
        }

        // Show the listing.
        return view('users.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $user = $this->user->makeModel();
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
        DB::beginTransaction();
        try {
            $user = $this->user->create($request->only($this->user->getFillable()));
            RolePermissionService::handleSave($request, $user);
            DB::commit();
            session()->flash('status', __('messages.success'));
            return redirect()->route($this->prefix.'users.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  integer $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $user = $this->user->findOrFail($id);
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
        $user = $this->user->with(['verifyUser'])->findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  App\Http\Requests\UserRequest  $request
    * @param  integer  $id
    * @return \Illuminate\Http\Response
    */
    public function update(UserRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);
        $verified = ($request->filled('verified')) ? 1 : 0;
        $active = ($request->filled('active')) ? 1 : 0;
        $attributes = array_merge($request->only($this->user->getFillable()), ['verified' => $verified], ['active' => $active]);
        if (empty($request->password)) {
            $attributes = array_except($attributes, 'password');
        }
        DB::beginTransaction();
        try {
            if ($user->update($attributes)) {
                RolePermissionService::handleSave($request, $user, 'sync');
                DB::commit();
                $request->session()->flash('status', __('messages.updated'));
                if ($this->isAdminRequest()) {
                    return redirect()->back();
                }
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  integer  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);
        if (auth()->user()->id !== $id) {
            DB::beginTransaction();
            try {
                if (LoginService::handleDelete($id)) {
                    if ($user->delete()) {
                        DB::commit();
                        session()->flash('status', __('messages.deleted'));
                        return back();
                    }
                }
            } catch (\Exception $e) {
                DB::rollback();
                return back()->withErrors($e->getMessage());
            }
        }
        return redirect()->back();
    }
}
