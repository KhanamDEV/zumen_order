<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 22/05/2022
 * Time: 10:40
 */


namespace App\Services\Worker;


use App\Jobs\SendMailOrder;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;

class ProjectService
{
    private $projectRepository;

    private $orderRepository;

    public function __construct(ProjectRepositoryInterface  $projectRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->orderRepository = $orderRepository;
    }

    public function getList($data){
//        $data['per_page'] = 10;
        if(!empty($data['delivery_date_range'])){
            $explodeDate = explode("-", $data['delivery_date_range']);
            $data['start_date'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[0]));
            $data['end_date'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[1]));
        }
        if (!empty($data['created_at'])){
            $explodeDate = explode("-", $data['created_at']);
            $data['created_at_start'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[0]));
            $data['created_at_end'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[1]));
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
//        $data['unexpired'] = true;
        return $this->projectRepository->getList(array_merge($data, []));
    }

    public function findById($id){
        return $this->projectRepository->findById($id, []);
    }

    public function doProject($id){
        $order = $this->orderRepository->find(['project_id' => $id]);
        if (empty($order)) return false;
        $status = $this->orderRepository->update($order->id, [
            'worker_id' => auth('workers')->user()->id,
            'status' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if ($status){
            $job = new SendMailOrder($order);
            dispatch($job)->delay(now()->addSeconds(2));
        }
        return $status;
    }


}
