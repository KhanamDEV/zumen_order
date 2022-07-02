<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 22/05/2022
 * Time: 11:52
 */


namespace App\Services\Worker;


use App\Repositories\Worker\WorkerRepositoryInterface;
use App\Services\System\UploadService;
use Illuminate\Support\Facades\Hash;

class WorkerService
{
    private $workerRepository;
    private $uploadService;

    public function __construct(WorkerRepositoryInterface $workerRepository, UploadService $uploadService)
    {
        $this->workerRepository = $workerRepository;
        $this->uploadService = $uploadService;
    }

    public function getList($data = []){
        return $this->workerRepository->getList($data);
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
        return $this->workerRepository->update(auth('workers')->user()->id, $dataUpdate);
    }

    public function updatePassword($data){
        $dataUpdate = [
            'password' => Hash::make($data['password']),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->workerRepository->update(auth('workers')->user()->id, $dataUpdate);
    }
}
