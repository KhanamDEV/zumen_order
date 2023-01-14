<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\ResponseHelpers;
use App\Services\Admin\ProjectService;
use App\Services\Admin\UserService;
use App\Services\Admin\WorkerService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Modules\Admin\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{

    private $projectService;
    private $userService;
    private $workerService;

    public function __construct(ProjectService $projectService, UserService $userService, WorkerService $workerService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->workerService = $workerService;
    }

    public function index(Request $request)
    {
        try {
            $data['projects'] = $this->projectService->getList($request->all());
            $data['users'] = $this->userService->getList();
            $data['workers'] = $this->workerService->getList();

            return view('admin::project.index', compact('data'));
        } catch (\Exception $e){
            dd($e);
            abort(500);
        }
    }

    public function analyticsByYear(Request $request){
        try {
            $data['projects'] = $this->projectService->getList($request->all());
            return  ResponseHelpers::showResponse($data['projects']);
        } catch (\Exception $e){
            return response()->json([]);
        }
    }

    public function show($id)
    {
        try {
            $data['project'] = $this->projectService->findById($id);
            if (empty($data['project'])) abort(500);
            return view('admin::project.show', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function destroy($id)
    {
        try {
            if ($this->projectService->delete($id)){
                session()->flash('message', '削除しました。');
                return redirect()->route('admin.project.index');
            }
            return back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function edit($id){
        try {
            $data['project'] = $this->projectService->findById($id);
            if (empty($data['project'])) abort(404);
            return view('admin::project.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function update(UpdateProjectRequest $request, $id){
        try {
            if (!$this->projectService->update($id, $request->all())){
                $errors = new MessageBag(['update_false' => __('message.alert.has_error')]);
                return redirect()->back()->withInput($request->all())->withErrors($errors);
            }
            session()->flash('message', '変更しました');
            return redirect()->route('admin.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function cancel($id){
        try {
            $this->projectService->cancel($id);
            session()->flash('message', 'キャンセルしました。');
            return redirect()->route('admin.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function continueProject($id){
        try {
            $this->projectService->continue($id);
            session()->flash('message', '続きまました。');
            return redirect()->route('admin.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }
}
