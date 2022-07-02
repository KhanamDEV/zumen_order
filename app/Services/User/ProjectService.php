<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 16:31
 */


namespace App\Services\User;


use App\Jobs\SendMailCreateProject;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    private $projectRepository;

    private $orderRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->orderRepository = $orderRepository;
    }

    public function store($data){
        DB::beginTransaction();
        try {
            $data['url'] = array_filter($data['url'], function ($value) {
                return !empty($value);
            });
            $dataInsert = [
                'user_id' => auth('users')->user()->id,
                'name' => $data['name'],
                'owner' => $data['owner'] ?? '',
                'type' => $data['type'] ?? '',
                'delivery_date' => $data['delivery_date'] ?? '',
                'importunate' => empty($data['importunate']) ? 0 : 1,
                'note' => $data['note'] ?? '',
                'other_information' => json_encode($data['other_information'] ?? []),
                'url' => json_encode($data['url'] ?? []),
                'documents' => $data['documents'],
                'postal_code' => $data['postal_code'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $projectId = $this->projectRepository->store($dataInsert);
            if (!$projectId) return false;
            $dataOrder = [
                'project_id' => $projectId,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $orderId = $this->orderRepository->store($dataOrder);
            if (!$orderId){
                DB::rollBack();
                return false;
            }
            $order = $this->orderRepository->find(['id' => $orderId]);
            $job = new SendMailCreateProject($order);
            dispatch($job)->delay(now()->addSeconds(2));
            DB::commit();
            return  $projectId;
        } catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function update($id, $data){
         $data['url'] = array_filter($data['url'], function ($value) {
            return !empty($value);
        });
        $dataUpdate = [
            'name' => $data['name'],
            'owner' => $data['owner'] ?? '',
            'type' => $data['type'] ?? '',
            'delivery_date' => $data['delivery_date'] ?? '',
            'importunate' => empty($data['importunate']) ? 0 : 1,
            'note' => $data['note'] ?? '',
            'other_information' => json_encode($data['other_information'] ?? []),
            'url' => json_encode($data['url'] ?? []),
            'postal_code' => $data['postal_code'],
            'documents' => $data['documents'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->projectRepository->update($id, $dataUpdate);
    }

    public function getList($data){
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
        return $this->projectRepository->getList(array_merge([], $data) );
    }

    public function findById($id){
        return $this->projectRepository->findById($id);
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->findById($id);
            if (empty($project) || !empty($project->order->worker_id)) return false;
            if (!$this->orderRepository->delete(['project_id' => $project->id])) return  false;
            if (!$this->projectRepository->delete($id)){
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            DB::rollBack();
            return  false;
        }

    }

    public function updateAdditional($id, $data){
        $data['url_additional'] = array_filter($data['url_additional'], function ($value) {
            return !empty($value);
        });
        $dataUpdate = [
            'url_additional' => json_encode($data['url_additional']),
            'additional' => $data['additional'],
            'documents_additional' => $data['documents_additional'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->projectRepository->update($id, $dataUpdate);
    }
}
