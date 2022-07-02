<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 22/05/2022
 * Time: 09:51
 */


namespace App\Services\Worker\Auth;


use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function login($data)
    {
        $remember = !empty($data['remember']);
        $login = Auth::guard('workers')->attempt(['email' => $data['email'], 'password' => $data['password']], $remember);
        if ($login){
            Auth::shouldUse('workers');
            return $login;
        }
        return  false;
    }
}
