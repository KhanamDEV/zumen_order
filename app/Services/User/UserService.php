<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 19:59
 */


namespace App\Services\User;


use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\UploadService;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $userRepository;
    private $uploadService;

    public function __construct(UserRepositoryInterface $userRepository, UploadService $uploadService)
    {
        $this->userRepository = $userRepository;
        $this->uploadService = $uploadService;
    }

    public function update($data){
        $dataUpdate = [
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone_number' => $data['phone_number'] ?? ''
        ];
        if (!empty($data['password'])) $dataUpdate['password'] = Hash::make($data['password']);
        if (request()->has('avatar')){
            $avatar = $this->uploadService->upload(request()->file('avatar'));
            if (!$avatar) return false;
            $dataUpdate['avatar'] = $avatar;
        }
        return $this->userRepository->update(auth('users')->user()->id, $dataUpdate);
    }

    public function updatePassword($data){
        $dataUpdate = [
            'password' => Hash::make($data['password']),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->userRepository->update(auth('users')->user()->id, $dataUpdate);
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
