<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 16:31
 */


namespace App\Services\User;


use App\Jobs\SendMailCreateProject;
use App\Repositories\Feedback\FeedbackRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\System\MailService;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    private $projectRepository;
    private $orderRepository;
    private $mailService;
    private $userRepository;
    private $feedbackRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository, OrderRepositoryInterface $orderRepository, MailService $mailService,
                                UserRepositoryInterface $userRepository, FeedbackRepositoryInterface $feedbackRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->orderRepository = $orderRepository;
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
        $this->feedbackRepository = $feedbackRepository;
    }

    public function store($data){
        DB::beginTransaction();
        try {
            $usersByCompany = $this->userRepository->getList(['company_id' => auth('users')->user()->company_id]);
            $lastProject = $this->projectRepository->getLastProjectByCompany(collect($usersByCompany)->pluck('id', 'id')->toArray());
            $user = $this->userRepository->findById(auth('users')->user()->id);
            $number = 1;
            if (!empty($lastProject)){
                $numberLastProject = str_replace($user->company->short_name, '', $lastProject->number);
                $number = (string) (abs($numberLastProject) + 1 );
            }
            $numberString = $user->company->short_name.'-';
            for ($i = 0; $i < (5 - strlen($number)); $i++){
                $numberString .= '0';
            }
            $numberString .= $number;
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
                'control_number' => $data['control_number'],
                'number' => $numberString,
                'postal_code' => $data['postal_code_head'].$data['postal_code_end'],
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
            if (env('APP_ENVIRONMENT') != 'local-nam'){
                $this->mailService->sendMailCreateProject($order);
            }
//            $job = new SendMailCreateProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
            DB::commit();
            return  $projectId;
        } catch (\Exception $e){
            DB::rollBack();
            dd($e);
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
            'postal_code' => $data['postal_code_head'].$data['postal_code_end'],
            'control_number' => $data['control_number'],
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
        if (!empty($data['year'])){
            if ($data['year'] != 'all'){
                $data['order_created_start'] = $data['year'].'-01-01';
                $data['order_created_end'] = $data['year'].'-12-31';
            }
        }
        if (!empty($data['finish_day'])){
            $explodeDate = explode("-", $data['finish_day']);
            $data['finish_day_start'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[0]));
            $data['finish_day_end'] = str_replace("/", '-', str_replace(" ", "", $explodeDate[1]));
        }
        $data['auth_type'] = 'user';
        $projects = $this->projectRepository->getList($data)->toArray();
        $projects = array_filter($projects, function ($item){
           return !empty($item['user']);
        });
//        if (!empty($data['project_type']) && $data['project_type'] == 'merge'){
//            $feedbacks = [];
//        }  else {
//            $feedbacks = $this->feedbackRepository->getList($data);
//            if (!empty($feedbacks)) $feedbacks = $feedbacks->toArray();
//        }

//        $projects = collect(array_merge($projects, $feedbacks))->toArray();
        usort($projects, function ($a, $b){
            return strtotime($a['created_at']) < strtotime($b['created_at']) ? 1 : 0;
        });
        $amountProject = ['all' => count($projects)];
        foreach (config('project.status') as $key => $status){
            if (!empty(config('project.color_status')[$key])) $amountProject[$key] = 0;
        }
        foreach ($projects as $key =>  $project){
            $projects[$key] = (object) $project;
            $projects[$key]->order = empty($project['project_id']) ? (object) $project['order']  : null;
            $projects[$key]->user = empty($project['project_id']) ?  (object) $project['user'] : (object) (!empty($project['project']['user']) ? $project['project']['user'] : null);
            if (empty($project['project_id'])){
                $amountProject[$project['order']['status']]++;
            } else{
                $amountProject[3]++;
            }
        }
        return [
            'list' => $projects,
            'amount' => $amountProject
        ];
    }

    public function findById($id){
        return $this->projectRepository->findById($id);
    }

    public function getChildProject($parentId){
        return $this->projectRepository->getChildProject($parentId);
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

    public function search($data){
        $projects = $this->projectRepository->getList($data);
        $uniqueProjects = [];
        foreach ($projects as $project){
            if (empty($uniqueProjects)){
                array_push($uniqueProjects, $project);
            } else{
                foreach ($uniqueProjects as $uniqueProject){
                    if ($uniqueProject->name != $project->name || $uniqueProject->owner != $project->owner || $uniqueProject->postal_code != $project->postal_code){
                        array_push($uniqueProjects, $project);
                    }
                }
            }
        }
        return $uniqueProjects;
    }

    public function addMessage($id, $data){
        $project = $this->projectRepository->findById($id);
        $order =$this->orderRepository->find(['project_id' => $id]);
        $messages = empty($project->messages) ? [] : json_decode($project->messages);
        $message = (object)[];
        $message->sender = 'order';
        $message->content = $data['content'];
        $message->documents = $data['documents'];
        $message->created_by = auth('users')->user()->id;
        $message->created_at = date('Y-m-d H:i:s');
        array_push($messages, $message);
        $status = $this->projectRepository->update($id, [
            'messages' => json_encode($messages),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if ($status && env('APP_ENVIRONMENT') != 'local-nam' ){
            $this->mailService->sendMailNewMessage($order, $message, 'order');
//            $job = new SendMailCompleteProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
        }
        return $status;
    }

    public function done($id){
        $order = $this->orderRepository->find(['project_id' => $id]);
        if (empty($order)) return false;
        $status = $this->orderRepository->update($order->id, [
            'status' => 3,
            'finish_day' => date('Y-m-d H:i:s')
        ]);
        if ($status && env('APP_ENVIRONMENT') != 'local-nam'){
            $order->finish_day = date('Y-m-d');
            $this->mailService->sendMailCompleteProject($order);
//            $job = new SendMailCompleteProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
        }
        return  $status;
    }
}
