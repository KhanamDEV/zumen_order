<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 24/05/2022
 * Time: 09:40
 */

namespace App\Services\Admin;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Worker\WorkerRepositoryInterface;
use App\Services\System\UploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WorkerService
{
    private $workerRepository;
    private $uploadService;
    private $orderRepository;

    public function __construct(WorkerRepositoryInterface $workerRepository, UploadService $uploadService, OrderRepositoryInterface $orderRepository)
    {
        $this->workerRepository = $workerRepository;
        $this->uploadService = $uploadService;
        $this->orderRepository = $orderRepository;
    }

    public function getList($data = []){
        return $this->workerRepository->getList($data);
    }

    public function findById($id){
        return $this->workerRepository->findById($id);
    }

    public function store($data){
        $dataInsert = [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'created_at' => date('Y-m-d H:i:s'),
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password'])
        ];
        if (request()->has('avatar')){
            $avatar = $this->uploadService->upload(request()->file('avatar'));
            if (!$avatar) return false;
            $dataInsert['avatar'] = $avatar;
        }
        return $this->workerRepository->store($dataInsert);
    }

    public function update($id, $data){
        $dataUpdate = [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'is_active' => $data['is_active'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        if (!empty($data['password'])) $dataUpdate['password'] = Hash::make($data['password']);
        if (request()->has('avatar')){
            $avatar = $this->uploadService->upload(request()->file('avatar'));
            if (!$avatar) return false;
            $dataUpdate['avatar'] = $avatar;
        }
        return $this->workerRepository->update($id, $dataUpdate);
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            if (!$this->workerRepository->delete($id)) return false;
            $orders = $this->orderRepository->getList(['worker_id' => $id]);
            foreach ($orders as $order){
                if (!$this->orderRepository->update($order->id, ['worker_id' => $id, 'documents' => json_encode([])])){
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
