<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\ResponseHelpers;
use App\Services\System\UploadService;
use App\Services\User\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\ChangePasswordRequest;
use Modules\User\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{
    private $uploadService;
    private $userService;

    public function __construct(UploadService  $uploadService, UserService $userService)
    {
        $this->uploadService = $uploadService;
        $this->userService = $userService;
    }

    public function edit()
    {
        try {
            $data['user'] = auth('users')->user();
            return  view('user::profile.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }



    public function update(UpdateProfileRequest $request)
    {
        try {
            $this->userService->update($request->all());
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function logOut(){
        auth('users')->logout();
        return redirect()->route('user.login');
    }

    public function changePassword(){
        try {
            return view('user::profile.change_password');
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function updatePassword(ChangePasswordRequest $request){
        try {
            if ($this->userService->updatePassword($request->all())){
                return redirect()->route('user.profile.edit');
            }
            return  redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function uploadFile(Request $request){
        try {
            return $this->uploadService->uploadAjax();
        } catch (\Exception $e){
            return ResponseHelpers::serverErrorResponse();
        }
    }
}
