<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use App\Repositories\adminRepository;
use Laracasts\Flash\Flash;

class adminController extends AppBaseController
{
    /** @var adminRepository */
    private $adminRepository;

    public function __construct(adminRepository $adminRepo)
    {
        $this->adminRepository = $adminRepo;
    }

    public function index()
    {
        return view('admins.index');
    }

    public function create()
    {
        $bloodGroup = getBloodGroups();

        return view('admins.create', compact('bloodGroup'));
    }

    public function store(CreateAdminRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $this->adminRepository->store($input);

        Flash::success(__('messages.admin').' '.__('messages.common.saved_successfully'));

        return redirect(route('admins.index'));
    }

    public function show($id)
    {
        $admin = $this->adminRepository->find($id);

        if (empty($admin) && $admin->owner_type != \App\Models\admin::class) {
            return view('errors.404');
        } else {
            return view('admins.show')->with('admin', $admin);
        }
    }

    public function edit(User $admin)
    {
        $bloodGroup = getBloodGroups();

        if (empty($admin) && $admin->owner_type != \App\Models\admin::class) {
            return view('errors.404');
        } else {
            return view('admins.edit', compact('admin', 'bloodGroup'));
        }
    }

    public function update(User $admin, UpdateAdminRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;

        $admin = $this->adminRepository->update($admin, $input);

        Flash::success(__('messages.admin').' '.__('messages.common.updated_successfully'));

        return redirect(route('admins.index'));
    }

    public function destroy(User $admin)
    {
        if (empty($admin) && $admin->owner_type != \App\Models\admin::class) {
            return $this->sendError(__('messages.admin').' '.__('messages.common.not_found'));
        } else {
            $admin->delete();

            return $this->sendSuccess(__('messages.admin').' '.__('messages.common.deleted_successfully'));
        }
    }

    public function activeDeactiveStatus($id)
    {
        $admin = User::find($id);

        if (empty($admin) && $admin->owner_type != \App\Models\admin::class) {
            return $this->sendError(__('messages.admin').' '.__('messages.common.not_found'));
        } else {
            $status = ! $admin->status;
            $admin->update(['status' => $status]);

            return $this->sendSuccess(__('messages.common.status_updated_successfully'));
        }
    }
}
