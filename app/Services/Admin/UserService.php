<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 24/05/2022
 * Time: 09:03
 */

namespace App\Services\Admin;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\UploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $userRepository;
    private $uploadService;
    private $orderRepository;
    private $projectRepository;

    public function __construct(UserRepositoryInterface $userRepository, UploadService $uploadService,
                                OrderRepositoryInterface $orderRepository, ProjectRepositoryInterface $projectRepository)
    {
        $this->userRepository = $userRepository;
        $this->uploadService = $uploadService;
        $this->orderRepository = $orderRepository;
        $this->projectRepository = $projectRepository;
    }

    public function getList($data = []){
        return $this->userRepository->getList($data);
    }

    public function findById($id){
        return $this->userRepository->findById($id);
    }

    public function store($data){
        $dataInsert = [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'created_at' => date('Y-m-d H:i:s'),
            'phone_number' => $data['phone_number'],
            'company_id' => $data['company_id'],
            'status' => $data['status'],
            'password' => Hash::make($data['password'])
        ];
        if (request()->has('avatar')){
            $avatar = $this->uploadService->upload(request()->file('avatar'));
            if (!$avatar) return false;
            $dataInsert['avatar'] = $avatar;
        }
        return $this->userRepository->store($dataInsert);
    }

    public function update($id, $data){
        $dataUpdate = [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company_id' => $data['company_id'],
            'status' => $data['status'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($data['password'])) $dataUpdate['password'] = Hash::make($data['password']);
        if (request()->has('avatar')){
            $avatar = $this->uploadService->upload(request()->file('avatar'));
            if (!$avatar) return false;
            $dataUpdate['avatar'] = $avatar;
        }
        return $this->userRepository->update($id, $dataUpdate);
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            if (!$this->userRepository->delete($id)) return false;
            $projects = $this->projectRepository->getList(['user_id' => $id]);
            foreach ($projects as $project){
                if (!$this->projectRepository->delete($project->id)){
                    DB::rollBack();
                    return false;
                }
                if (!$this->orderRepository->delete(['project_id', $project->id])){
                    DB::rollBack();
                    return  false;
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            abort(500);
        }
    }
}
