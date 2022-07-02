<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\ProjectService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Modules\User\Http\Requests\CreateProjectRequest;
use Modules\User\Http\Requests\UpdateAdditionalProjectRequest;
use Modules\User\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    private $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        try {
            $data['workers'] = DB::table('workers')->get();
            $data['projects'] = $this->projectService->getList($request->all());
            return view('user::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function create()
    {
        try {
            return view('user::project.create');
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function store(CreateProjectRequest $request)
    {
        try {
            $id = $this->projectService->store($request->all());
            if (!$id){
                $errors = new MessageBag(['create_false' => __('message.alert.has_error')]);
                return redirect()->back()->withInput($request->all())->withErrors($errors);
            }
            session()->flash('message', 'message');
            return redirect()->route('user.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }




    public function edit($id)
    {
        try {
            $project = $this->projectService->findById($id);
            if (empty($project) || !empty($project->order->worker_id)) abort(404);
            $data['project'] = $this->projectService->findById($id);
            if (empty($data['project'])) abort(404);
            return view('user::project.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function update(UpdateProjectRequest $request, $id)
    {
        try {

            if (!$this->projectService->update($id, $request->all())){
                $errors = new MessageBag(['update_false' => __('message.alert.has_error')]);
                return redirect()->back()->withInput($request->all())->withErrors($errors);
            }
            return redirect()->route('user.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function show($id)
    {
        try {
            $data['project'] = $this->projectService->findById($id);
            if (empty($data['project'])) abort(404);
            return view('user::project.show', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function destroy($id){
        try {
            $project = $this->projectService->findById($id);
            if (empty($project) || !empty($project->order->worker_id)) abort(404);
            if ($this->projectService->delete($id)){
                return redirect()->route('user.project.index');
            }
            return  redirect()->route('user.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function updateAdditional(UpdateAdditionalProjectRequest $request, $id){
        try {
            if ($this->projectService->updateAdditional($id, $request->all())){
                session()->flash('update_additional_success', 'Success');
            }
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }
}
