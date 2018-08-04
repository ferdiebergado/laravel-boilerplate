<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface as UserRepository;
use App\Criteria\RequestCriteria;
use Illuminate\Http\Request;
use App\Services\RolePermissionService;
use Illuminate\Support\Facades\DB;
use App\Services\LoginService;
use App\Criteria\WithTrashedCriteria;

class UserService
{
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
        $this->user->pushCriteria(new WithTrashedCriteria);
    }

    public function list(Request $request)
    {
        // Fetch paginated list of Users based on parameters from the Request (sent by datatables).
        return $this->user->getByCriteria(new RequestCriteria($request))->paginate($request->length);
    }

    public function create()
    {
        return $this->user->makeModel();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->user->create($request->only($this->user->getFillable()));
            RolePermissionService::handleSave($request, $user);
            DB::commit();
            session()->flash('status', __('messages.success'));
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('errors', $e->getMessage());
            return false;
        }
    }

    public function show($id)
    {
        return $this->user->findOrFail($id);
    }

    public function edit($id)
    {
        return $this->user->with(['verifyUser'])->findOrFail($id);
    }

    public function update(Request $request, $id, $method)
    {
        $user = $this->user->findOrFail($id);
        if (empty($method)) {
            $attributes = $request->only($this->user->getFillable());
            if (auth()->user()->can('edit-users', $user)) {
                $verified = ($request->filled('verified')) ? 1 : 0;
                $active = ($request->filled('active')) ? 1 : 0;
                $attributes = array_merge($attributes, ['verified' => $verified], ['active' => $active]);
            }
            if (empty($request->password)) {
                $attributes = array_except($attributes, 'password');
            }
            DB::beginTransaction();
            try {
                if ($user->update($attributes)) {
                    RolePermissionService::handleSave($request, $user, 'sync');
                    DB::commit();
                    session()->flash('status', __('messages.updated'));
                }
            } catch (\Exception $e) {
                DB::rollBack();
            }
        } else {
            SoftDeletedModelService::handle($user, $method);
        }
    }

    public function delete($id)
    {
        $user = $this->user->findOrFail($id);
        if (auth()->user()->can('delete', $user)) {
            if (auth()->user()->id != $id) {
                DB::beginTransaction();
                try {
                    LoginService::handleDelete($id);
                    if ($user->forceDelete()) {
                        DB::commit();
                        session()->flash('status', __('messages.deleted'));
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    session()->flash('errors', $e->getMessage());
                }
            } else {
                session()->flash('errors', __('messages.delete_self'));
            }
        }
    }
}
