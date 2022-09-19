<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 09/08/2022
 * Time: 12:44
 */


namespace App\Services\Admin;


use App\Repositories\Feedback\FeedbackRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FeedbackService
{
    private $feedbackRepository;
    private $projectRepository;
    private $orderRepository;

    public function __construct(FeedbackRepositoryInterface  $feedbackRepository,
                                ProjectRepositoryInterface $projectRepository,
                                OrderRepositoryInterface $orderRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->projectRepository = $projectRepository;
        $this->orderRepository = $orderRepository;
    }

    public function store($data){
        DB::rollBack();
        try {
            $project = $this->projectRepository->findById($data['project_id']);
            if (empty($project)) return false;
            $dataFeedback = [
                'project_id' => $project->id,
                'name' => $project->name,
                'owner' => $project->owner,
                'type' => $project->type,
                'worker_id' => $project->order->worker_id,
                'delivery_date' => $project->delivery_date,
                'finish_day' => $project->order->finish_day,
                'url' => $project->url,
                'note' => $project->note,
                'documents' => $project->documents,
                'postal_code' => $project->postal_code,
                'additional' => $project->additional,
                'url_additional' => $project->url_additional,
                'documents_additional' => $project->documents_additional,
                'importunate' => $project->importunate,
                'project_created_at' => Carbon::parse($project->created_at)->format('Y-m-d H:i:s'),
                'documents_of_worker' => $project->order->documents,
                'other_information' => $project->other_information,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $dataUpdateProject = [
                'type' => $data['type'],
                'delivery_date' => $data['delivery_date'],
                'documents' => $data['documents'],
                'importunate' => empty($data['importunate']) ? 0 : 1,
                'created_at' => date('Y-m-d H:i:s'),
                'additional' => '',
                'documents_additional' => null,
                'url_additional' => null
            ];
            $dataUpdateOrder = [
                'status' => 2,
                'documents' => json_encode([]),
                'finish_day' => null,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            if (!$this->feedbackRepository->store($dataFeedback)){
                return false;
            }
            if (!$this->projectRepository->update($project->id, $dataUpdateProject)){
                DB::rollBack();
                return false;
            }
            if (!$this->orderRepository->update($project->order->id, $dataUpdateOrder)){
                DB::rollBack();
                return false;
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