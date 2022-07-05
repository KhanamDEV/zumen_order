<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 22/05/2022
 * Time: 14:57
 */


namespace App\Services\Worker;


use App\Jobs\SendMailCompleteProject;
use App\Jobs\SendMailLeaveProject;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\System\MailService;

class OrderService
{
    private $orderRepository;

    private $mailService;

    public function __construct(OrderRepositoryInterface  $orderRepository, MailService $mailService)
    {
        $this->orderRepository = $orderRepository;
        $this->mailService = $mailService;
    }

    public function getList($data){
        if(!empty($data['delivery_date_range'])){
            $explodeDate = explode("-", $data['delivery_date_range']);
            $data['start_date'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[0]));
            $data['end_date'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[1]));
        }
        if (!empty($data['created_at'])){
            $explodeDate = explode("-", $data['created_at']);
            $data['project_created_start'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[0]));
            $data['project_created_end'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[1]));
        }
        if (!empty($data['order_created'])){
            $explodeDate = explode("-", $data['order_created']);
            $data['order_created_start'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[0]));
            $data['order_created_end'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[1]));
        }
        if (!empty($data['finish_day'])){
            $explodeDate = explode("-", $data['finish_day']);
            $data['finish_day_start'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[0]));
            $data['finish_day_end'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[1]));
        }
        return $this->orderRepository->getList(array_merge($data, []));
    }

    public function findById($id){
        return $this->orderRepository->find(['id' => $id]);
    }

    public function update($id, $data){
        $dataUpdate = [
            'documents' => $data['documents'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if (!empty($data['status'])){
            $dataUpdate['status'] = $data['status'];
        }
        return $this->orderRepository->update($id, $dataUpdate);
    }

    public function leaveProject($id){
        $order = $this->orderRepository->find(['id' => $id]);
        if (empty($order)) return false;

        $dataUpdate = [
            'status' => 1,
            'worker_id' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $status = $this->orderRepository->update($id, $dataUpdate);
        if ($status){
            $order->updated_at = date('Y-m-d');
            $this->mailService->sendMailLeaveProject($order);
//            $job = new SendMailLeaveProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
        }
        return  $status;

    }

    public function doneProject($id){
        $order = $this->orderRepository->find(['id' => $id]);
        if (empty($order)) return false;
        $status = $this->orderRepository->update($order->id, [
            'status' => 3,
            'finish_day' => date('Y-m-d H:i:s')
        ]);
        if ($status){
            $order->finish_day = date('Y-m-d');
            $this->mailService->sendMailCompleteProject($order);
//            $job = new SendMailCompleteProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
        }
        return  $status;
    }
}
