<?php

namespace App\Jobs;

use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Worker\WorkerRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailContinueProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param WorkerRepositoryInterface $workerRepository
     * @param AdminRepositoryInterface $adminRepository
     * @param UserRepositoryInterface $userRepository
     * @return void
     */
    public function handle(WorkerRepositoryInterface  $workerRepository,
                           AdminRepositoryInterface  $adminRepository, UserRepositoryInterface $userRepository)
    {
//        $admins = $adminRepository->getList();
        $workers = $workerRepository->getList();
        $users = $userRepository->getList(['email' => $this->order->project->user->email]);
//        foreach ($admins as $admin){
//            $job = new SendMailCompleteProjectSingle('admin', $this->order, $admin->email);
//            dispatch($job)->delay(now()->addSeconds(4));
//        }
        foreach ($workers as $worker){
            $job = new SendMailContinueProjectSingle('worker', $this->order, $worker->email);
            dispatch($job)->delay(now()->addSeconds(4));
        }
        foreach ($users as $user){
            $job = new SendMailContinueProjectSingle('user', $this->order, $user->email);
            dispatch($job)->delay(now()->addSeconds(4));
        }
    }
}
