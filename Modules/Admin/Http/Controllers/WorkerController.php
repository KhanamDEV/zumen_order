<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\Admin\WorkerService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\CreateWorkerRequest;
use Modules\Admin\Http\Requests\UpdateWorkerRequest;

class WorkerController extends Controller
{

    private $workerService;

    public function __construct(WorkerService $workerService)
    {
        $this->workerService = $workerService;
    }

    public function index(Request $request)
    {
        try {
            $data['workers'] = $this->workerService->getList($request->all());
            return view('admin::worker.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function create()
    {
        try {
            return view('admin::worker.create');
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function store(CreateWorkerRequest $request )
    {
        try {
            $id = $this->workerService->store($request->all());
            if ($id){
                session()->flash('message', 'create_success');
                return redirect()->route('admin.worker.index');
            }
            return  redirect()->back()->withInput($request->all());
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function show($id)
    {
        try {
            $data['worker'] = $this->workerService->findById($id);
            return view('admin::worker.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function edit($id)
    {
        try {
            $data['worker'] = $this->workerService->findById($id);
            return view('admin::worker.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function update(UpdateWorkerRequest $request, $id)
    {
        try {
            $this->workerService->update($id, $request->all());
            return back();
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function destroy($id)
    {
        try {
            if ($this->workerService->delete($id)) return redirect()->route('admin.worker.index');
            return  back();
        } catch (\Exception $e){
            abort(500);
        }
    }
}
