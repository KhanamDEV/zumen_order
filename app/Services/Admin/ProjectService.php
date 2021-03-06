<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 24/05/2022
 * Time: 08:56
 */

namespace App\Services\Admin;

use App\Jobs\SendMailCancelProject;
use App\Jobs\SendMailCompleteProject;
use App\Jobs\SendMailContinueProject;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Services\System\MailService;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    private $projectRepository;

    private $orderRepository;

    private $mailService;

    public function __construct(ProjectRepositoryInterface  $projectRepository, OrderRepositoryInterface $orderRepository, MailService $mailService)
    {
        $this->projectRepository = $projectRepository;
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
        $projects = $this->projectRepository->getList($data);
        $amountProject = ['all' => count($projects)];
        foreach (config('project.status') as $key => $status){
            if (!empty(config('project.color_status')[$key])) $amountProject[$key] = 0;
        }
        foreach ($projects as $project){
            $amountProject[$project->order->status]++;
        }
        return [
            'list' => $projects,
            'amount' => $amountProject
        ];
    }

    public function findById($id){
        return $this->projectRepository->findById($id);
    }

    public function delete($id){
        DB::beginTransaction();
        try {

            $project = $this->projectRepository->findById($id);
            if ($project->order->status == 3) return false;
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
            'documents' => $data['documents'],
            'postal_code' => $data['postal_code_head'].$data['postal_code_end'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->projectRepository->update($id, $dataUpdate);
    }

    public function cancel($id){
        $order = $this->orderRepository->find(['project_id' => $id]);
        if ($order->status  == 3) return false;
        $status = $this->orderRepository->update($order->id, [
            'status' => 5,
            'worker_id' => null,
            'documents' => json_encode([]),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if ($status && env('APP_ENVIRONMENT') != 'local-nam'){
            $order->updated_at = date('Y-m-d H:i:s');
            $this->mailService->sendMailCancelProject($order);
//            $job = new SendMailCancelProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
        }
        return  $status;
    }

    public function continue($id){
        $order = $this->orderRepository->find(['project_id' => $id]);
        if ($order->status  == 3) return false;
        $status =  $this->orderRepository->update($order->id, [
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if ($status && env('APP_ENVIRONMENT') != 'local-nam'){
            $order->updated_at = date('Y-m-d H:i:s');
            $this->mailService->sendMailContinueProject($order);
//            $job = new SendMailContinueProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
        }
        return  $status;
    }
}
