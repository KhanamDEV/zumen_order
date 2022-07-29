<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 04/07/2022
 * Time: 19:45
 */


namespace App\Services\System;


use App\Mail\MailCancelProject;
use App\Mail\MailCompleteProject;
use App\Mail\MailContinueProject;
use App\Mail\MailCreateProject;
use App\Mail\MailLeaveProject;
use App\Mail\MailOrder;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Worker\WorkerRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class MailService
{
    private $workerRepository;

    private $adminRepository;

    private $userRepository;

    public function __construct(WorkerRepositoryInterface $workerRepository, AdminRepositoryInterface $adminRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->workerRepository = $workerRepository;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
    }

    public function sendMailCancelProject($order){
        $workers = $this->workerRepository->getList();
        $users = $this->userRepository->getList(['email' => $order->project->user->email]);
        foreach ($workers as $worker){
            Mail::to($worker->email)->send(new MailCancelProject('worker', $order));
        }
        foreach ($users as $user){
            Mail::to($user->email)->send(new MailCancelProject('user', $order));
        }
    }

    public function sendMailCompleteProject($order){
//        $admins = $this->adminRepository->getList();
        $workers = $this->workerRepository->getList();
        $users = $this->userRepository->getList(['email' => $order->project->user->email]);
//        foreach ($admins as $admin){
//            Mail::to($admin->email)->send(new MailCompleteProject('admin', $order));
//        }
        foreach ($workers as $worker){
            Mail::to($worker->email)->send(new MailCompleteProject('worker', $order));
        }
        foreach ($users as $user){
            Mail::to($user->email)->send(new MailCompleteProject('user', $order));
        }
    }

    public function sendMailContinueProject($order){
        $workers = $this->workerRepository->getList();
        $users = $this->userRepository->getList(['email' => $order->project->user->email]);
        foreach ($workers as $worker){
            Mail::to($worker->email)->send(new MailContinueProject('worker', $order));
        }
        foreach ($users as $user){
            Mail::to($user->email)->send(new MailContinueProject('user', $order));
        }
    }

    public function sendMailCreateProject($order){
//        $admins = $this->adminRepository->getList();
        $workers = $this->workerRepository->getList();
        $users = $this->userRepository->getList(['email' => $order->project->user->email]);
//        foreach ($admins as $admin){
//            Mail::to($admin->email)->send(new MailCreateProject('admin', $order));
//        }
        foreach ($workers as $worker){
            Mail::to($worker->email)->send(new MailCreateProject('worker', $order));
        }
        foreach ($users as $user){
            Mail::to($user->email)->send(new MailCreateProject('user', $order));
        }
    }

    public function sendMailLeaveProject($order){
//        $admins = $this->adminRepository->getList();
        $workers = $this->workerRepository->getList();
        $users = $this->userRepository->getList(['email' => $order->project->user->email]);
//        foreach ($admins as $admin){
//            Mail::to($admin->email)->send(new MailLeaveProject('admin', $order));
//        }
        foreach ($workers as $worker){
            Mail::to($worker->email)->send(new MailLeaveProject('worker', $order));
        }
        foreach ($users as $user){
            Mail::to($user->email)->send(new MailLeaveProject('user', $order));
        }
    }

    public function sendMailOrderProject($order){
//        $admins = $this->adminRepository->getList();
        $workers = $this->workerRepository->getList();
        $users = $this->userRepository->getList(['email' => $order->project->user->email]);
//        foreach ($admins as $admin){
//            Mail::to($admin->email)->send(new MailOrder('admin', $order));
//        }
        foreach ($workers as $worker){
            Mail::to($worker->email)->send(new MailOrder('worker', $order));
        }
        foreach ($users as $user){
            Mail::to($user->email)->send(new MailOrder('user', $order));
        }
    }
}
