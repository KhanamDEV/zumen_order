<?php

namespace Modules\Admin\Http\Controllers\Auth;

use App\Services\Admin\Auth\LoginService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Modules\Admin\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function getLogin(){
        try {
            if (auth('admins')->check()) return redirect()->route('admin.project.index');
            return view('admin::auth.login');
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function postLogin(AdminLoginRequest $request){
        try {
            if ($this->loginService->login($request->all())){
                return redirect()->route('admin.project.index');
            }
            $errors = new MessageBag(['authenticate' => __('auth.failed')]);
            return back()->withInput($request->all())->withErrors($errors);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function logout(){
        auth('admins')->logout();
        return redirect()->route('admin.login');
    }
}
