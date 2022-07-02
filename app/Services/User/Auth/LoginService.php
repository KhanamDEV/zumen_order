<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 13:46
 */


namespace App\Services\User\Auth;


use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function login($data)
    {
        $remember = !empty($data['remember']);
        $login = Auth::guard('users')->attempt(['email' => $data['email'], 'password' => $data['password']], $remember);
        if ($login){
            Auth::shouldUse('users');
            return $login;
        }
        return  false;
    }
}
