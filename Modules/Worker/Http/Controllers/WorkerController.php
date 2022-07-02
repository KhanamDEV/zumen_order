<?php

namespace Modules\Worker\Http\Controllers;

use App\Services\Worker\WorkerService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Worker\Http\Requests\ChangePasswordRequest;
use Modules\Worker\Http\Requests\UpdateProfileRequest;

class WorkerController extends Controller
{

    private $workerService;

    public function __construct(WorkerService $workerService)
    {
        $this->workerService = $workerService;
    }

    public function edit()
    {
        $data['worker'] = auth('workers')->user();
        return view('worker::profile.edit', compact('data'));
    }


    public function update(UpdateProfileRequest $request)
    {
        try {
            $this->workerService->update($request->all());
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function changePassword(){
        try {
            return view('worker::profile.change_password');
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function updatePassword(ChangePasswordRequest $request){
        try {
            if ($this->workerService->updatePassword($request->all())){
                return redirect()->route('worker.profile.edit');
            }
            return  redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }

}
