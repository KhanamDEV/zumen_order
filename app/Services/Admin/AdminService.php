<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 24/05/2022
 * Time: 09:53
 */

namespace App\Services\Admin;

use App\Repositories\Admin\AdminRepositoryInterface;
use App\Services\System\UploadService;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    private $adminRepository;
    private $uploadService;

    public function __construct(AdminRepositoryInterface $adminRepository, UploadService $uploadService)
    {
        $this->adminRepository = $adminRepository;
        $this->uploadService = $uploadService;
    }

    public function update($data){
        $dataUpdate = [
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone_number' => $data['phone_number'] ?? ''
        ];
        if (request()->has('avatar')){
            $avatar = $this->uploadService->upload(request()->file('avatar'));
            if (!$avatar) return false;
            $dataUpdate['avatar'] = $avatar;
        }
        return $this->adminRepository->update(auth('admins')->user()->id, $dataUpdate);
    }

    public function updatePassword($data){
        $dataUpdate = [
            'password' => Hash::make($data['password']),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->adminRepository->update(auth('admins')->user()->id, $dataUpdate);
    }
}
