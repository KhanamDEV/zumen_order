<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 19/12/2022
 * Time: 22:48
 */


namespace App\Services\Worker;


use App\Repositories\User\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function pluckNameById(){
        $userList = $this->userRepository->getList([]);
        $users = [];
        foreach ($userList as $user){
            $users[$user->id] = $user->first_name.' '.$user->last_name;
        }
        return $users;
    }
}
