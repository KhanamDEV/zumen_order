<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\Admin\UserService;
use App\Services\Admin\WorkerService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\CreateUserRequest;
use Modules\Admin\Http\Requests\CreateWorkerRequest;
use Modules\Admin\Http\Requests\UpdateWorkerRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $data['users'] = $this->userService->getList($request->all());
            return view('admin::user.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function create()
    {
        try {
            return view('admin::user.create');
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function store(CreateUserRequest $request )
    {
        try {
            $id = $this->userService->store($request->all());
            if ($id){
                session()->flash('message', 'create_success');
                return redirect()->route('admin.user.index');
            }
            return  redirect()->back()->withInput($request->all());
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function show($id)
    {
        try {
//            $data['worker'] = $this->workerService->findById($id);
//            return view('admin::worker.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function edit($id)
    {
        try {
            $data['user'] = $this->userService->findById($id);
            return view('admin::user.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function update(UpdateWorkerRequest $request, $id)
    {
        try {
            $this->userService->update($id, $request->all());
            return back();
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function destroy($id)
    {
        try {
            if ($this->userService->delete($id)) return redirect()->route('admin.user.index');
            return  back();
        } catch (\Exception $e){
            abort(500);
        }
    }
}
