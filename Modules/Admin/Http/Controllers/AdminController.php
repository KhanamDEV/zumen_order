<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\Admin\AdminService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\UpdateProfileRequest;
use Modules\Admin\Http\Requests\ChangePasswordRequest;

class AdminController extends Controller
{

    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function edit(){
        try {
            $data['admin'] = auth('admins')->user();
            return view('admin::profile.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function update(UpdateProfileRequest $request){
        try {
            $this->adminService->update($request->all());
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function changePassword(){
        try {
            return view('admin::profile.change_password');
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function updatePassword(ChangePasswordRequest $request){
        try {
            if ($this->adminService->updatePassword($request->all())){
                return redirect()->route('admin.profile.edit');
            }
            return  redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }
}
