<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 19/12/2022
 * Time: 22:39
 */


namespace App\Services\User;


use App\Repositories\Worker\WorkerRepositoryInterface;

class WorkerService
{

    private $workerRepository;

    public function __construct(WorkerRepositoryInterface $workerRepository)
    {
        $this->workerRepository = $workerRepository;
    }

    public function pluckNameById(){
        $workerList = $this->workerRepository->getList(['is_active' => 1]);
        $workers = [];
        foreach ($workerList as $worker){
            $workers[$worker->id] = $worker->first_name.' '.$worker->last_name;
        }
        return $workers;
    }

}
