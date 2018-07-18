<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use App\Criteria\RequestCriteria;
use App\Http\Controllers\BaseController;
use App\Services\RolePermissionService;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController
{
    private $role;
    
    public function __construct(RoleRepository $role)
    {
        $this->middleware('auth');
        $this->role = $role;
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // Fetch paginated list of Users based on parameters from the Request (sent by datatables).
        $roles = $this->role->getByCriteria(new RequestCriteria(request()))->paginate(request()->length);
        
        // Send the response as JSON.
        
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => request()->draw,
                'data' => $roles
                ]);
        }
        return view('roles.index');
    }
        
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $role = new Role();
        return view('roles.create', compact('role'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(RoleRequest $request)
    {
        if ($this->role->create($request->only($this->role->getFillable()))) {
            return view('roles.index')->with('status', __('messages.saved'));
        }
    }
        
    /**
    * Display the specified resource.
    *
    * @param  \App\Role  $role
    * @return \Illuminate\Http\Response
    */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }
        
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Role  $role
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $role = $this->role->findOrFail($id);
        return view('roles.edit', compact('role'));
    }
        
    /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\RoleRequest  $request
    * @param  \App\Role  $role
    * @return \Illuminate\Http\Response
    */
    public function update(RoleRequest $request, $id)
    {
        $role = $this->role->findOrFail($id);
        DB::beginTransaction();
        try {
            if ($role->update($request->only($this->role->getFillable()))) {
                // Update permissions
                if ($request->filled('permissions')) {
                    // Sync selected permissions
                    foreach (array($request->permissions) as $id) {
                        $role->permissions()->sync(app('App\\Permission')->findOrFail($id));
                    }
                } else {
                    // Detach all permissions
                    foreach ($role->permissions as $permission) {
                        // Only detach the permission if the current user does not have the permission being deleted
                        if (!(auth()->user()->hasPermission($permission))) {
                            $role->permissions()->detach($permission);
                        } else {
                            return redirect()->back()->withErrors($permission->slug . ': ' . __('messages.permissionself'));
                        }
                    }
                }
                DB::commit();
                $request->session()->flash('status', __('messages.updated'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage());
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
        $role = $this->role->findOrFail($id);
        if (!auth()->user()->hasRole($role->slug)) {
            try {
                $role->delete();
                return back()->with('status', __('messages.deleted'));
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }
        return redirect()->back()->withErrors(__('messages.roleself'));
    }
}
