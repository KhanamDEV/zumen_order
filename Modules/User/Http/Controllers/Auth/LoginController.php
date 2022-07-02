<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Services\User\Auth\LoginService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Modules\User\Http\Requests\UserLoginRequest;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function getLogin()
    {
        try {
            if (auth()->guard('users')->check()) return redirect()->route('user.project.index');
            return view('user::auth.login');
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function postLogin(UserLoginRequest $request)
    {
        try {
            if ($this->loginService->login($request->all())){
                return redirect()->route('user.project.index');
            }
            $errors = new MessageBag(['authenticate' => __('auth.failed')]);
            return back()->withInput($request->all())->withErrors($errors);
        } catch (\Exception $e){
            abort(500);
        }
    }
}
