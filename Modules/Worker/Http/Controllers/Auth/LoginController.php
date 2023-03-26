<?php

namespace Modules\Worker\Http\Controllers\Auth;

use App\Services\Worker\Auth\LoginService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Modules\Worker\Http\Requests\WorkerLoginRequest;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function getLogin(){
        try {
            if(auth('workers')->check()) return  redirect()->route('worker.project.index');
            return view('worker::auth.login');
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function postLogin(WorkerLoginRequest $request){
        try {
            if ($this->loginService->login($request->all())){
                if (!auth('workers')->user()->is_active){
                    auth('workers')->logout();
                    $errors = new MessageBag(['authenticate' => __('あなたのアカウントは非アクティブです')]);
                    return back()->withInput($request->all())->withErrors($errors);
                }
                return redirect()->route('worker.project.index');
            }
            $errors = new MessageBag(['authenticate' => __('auth.failed')]);
            return back()->withInput($request->all())->withErrors($errors);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function logout(){
        auth('workers')->logout();
        return redirect()->route('worker.login');
    }
}
