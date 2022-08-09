<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 09/08/2022
 * Time: 13:07
 */


namespace App\Services\Worker;


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


    public function findById($id){
        return $this->feedbackRepository->findById($id);
    }
}
