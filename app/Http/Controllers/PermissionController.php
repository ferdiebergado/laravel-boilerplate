<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;
use App\Criteria\RequestCriteria;
use App\Http\Controllers\BaseController;

class PermissionController extends BaseController
{
    private $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->middleware('auth');
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch paginated list of Users based on parameters from the Request (sent by datatables).
        $permissions = $this->permission->getByCriteria(new RequestCriteria(request()))->paginate(request()->length);

        // Send the response as JSON.

        if (request()->wantsJson()) {
            return response()->json([
                'draw' => request()->draw,
                'data' => $permissions
            ]);
        }
        return view('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = new Permission();
        return view('permissions.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        if ($this->permission->create($request->only($this->permission->getFillable()))) {
            $request->session()->flash('status', __('messages.saved'));
            return view('permissions.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('roles.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = $this->permission->findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PermissionRequest  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $permission = $this->permission->findOrFail($id);
        if ($permission->update($request->only($this->permission->getFillable()))) {
            $request->session()->flash('status', __('messages.updated'));
            if ($this->isAdminRequest()) {
                return redirect()->route('admin.permissions.index');
            }
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
        $permission = $this->permission->findOrFail($id);
        if (!auth()->user()->hasRole($permission->slug)) {
            try {
                $permission->delete();
                return back()->with('status', __('messages.deleted'));
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }
        return redirect()->back()->withErrors(__('messages.permissionself'));
    }
}
