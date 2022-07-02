<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 24/05/2022
 * Time: 08:49
 */

namespace App\Services\Admin\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function login($data)
    {
        $remember = !empty($data['remember']);
        $login = Auth::guard('admins')->attempt(['email' => $data['email'], 'password' => $data['password']], $remember);
        if ($login){
            Auth::shouldUse('admins');
            return $login;
        }
        return  false;
    }
}
