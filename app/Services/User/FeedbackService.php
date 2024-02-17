<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 07/08/2022
 * Time: 15:56
 */


namespace App\Services\User;


use App\Repositories\Feedback\FeedbackRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Services\System\MailService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FeedbackService
{
    private $feedbackRepository;
    private $projectRepository;
    private $orderRepository;
    private $mailService;

    public function __construct(FeedbackRepositoryInterface  $feedbackRepository,
                                ProjectRepositoryInterface $projectRepository,
                                OrderRepositoryInterface $orderRepository, MailService $mailService)
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->projectRepository = $projectRepository;
        $this->orderRepository = $orderRepository;
        $this->mailService = $mailService;
    }

    public function store($data){
        DB::rollBack();
        try {
            $project = $this->projectRepository->findById($data['project_id']);
            if (empty($project)) return false;
            $dataInsertProject = [
                'user_id' => $project->user_id,
                'name' => $project->name,
                'owner' => $project->owner,
                'type'  => $project->type,
                'delivery_date' => $project->delivery_date,
                'importunate' => $project->importunate,
                'note' => $project->note,
                'other_information' => $project->other_information,
                'url' => $project->url,
                'documents' => $project->documents,
                'created_at' => $project->created_at,
                'building' => $project->building,
                'updated_at' => null,
                'postal_code' => $project->postal_code,
                'additional' => $project->additional,
                'url_additional' => $project->url_additional,
                'documents_additional' => $project->documents_additional,
                'messages' => $project->messages,
                'control_number' => $project->control_number,
                'number' => $project->number,
                'parent_project_id' => $project->id,
            ];
            $newProjectId = $this->projectRepository->store($dataInsertProject);
            $dataOrder = [
                'project_id' => $newProjectId,
                'worker_id' => $project->order->worker_id,
                'status' => 3,
                'finish_day' => $project->order->finish_day,
                'documents' => $project->order->documents,
                'created_at' => $project->order->created_at
            ];
            $this->orderRepository->store($dataOrder);
            $dataUpdateProject = [
                'type' => $data['type'],
                'delivery_date' => $data['delivery_date'],
                'documents' => $data['documents'],
                'messages' => null,
                'importunate' => empty($data['importunate']) ? 0 : 1,
                'created_at' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + 1),
                'note' => $data['note'],
                'additional' => '',
                'documents_additional' => null,
                'url_additional' => null,
                'url' => json_encode($data['url'] ?? []),
                'postal_code' => $data['postal_code_head'].$data['postal_code_end'],
                'name' => $data['name'],
            ];
            $dataUpdateOrder = [
                'status' => 1,
                'documents' => json_encode([]),
                'finish_day' => null,
                'worker_id' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->projectRepository->update($project->id, $dataUpdateProject)){
                DB::rollBack();
                return false;
            }
            if (!$this->orderRepository->update($project->order->id, $dataUpdateOrder)){
                DB::rollBack();
                return false;
            }
            $order = $this->orderRepository->find(['id' => $project->order->id]);
            if (env('APP_ENVIRONMENT') != 'local-nam' ){
                $this->mailService->sendMailCreateProject($order, true);
//            $job = new SendMailCompleteProject($order);
//            dispatch($job)->delay(now()->addSeconds(2));
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            DB::rollBack();
            return false;
        }

    }

    public function delete($id){
        return $this->feedbackRepository->delete($id);
    }

    public function findById($id){
        return $this->feedbackRepository->findById($id);
    }
}
