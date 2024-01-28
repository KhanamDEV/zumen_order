<?php

namespace Modules\User\Http\Controllers;

use App\Helpers\ResponseHelpers;
use App\Services\User\ProjectService;
use App\Services\User\UserService;
use App\Services\User\WorkerService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\MessageBag;
use Modules\User\Http\Requests\CreateProjectRequest;
use Modules\User\Http\Requests\UpdateAdditionalProjectRequest;
use Modules\User\Http\Requests\UpdateProjectRequest;

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
            $data['workers'] = DB::table('workers')->where('is_active', 1)->get();
            $data['projects'] = $this->projectService->getList(array_merge($request->all(), ['user_id' => auth('users')->id(), 'project_type' => 'merge']));
            $data['users'] = DB::table('users')->where('status', 1)->where('company_id', auth()->guard('users')->user()->company_id)->get();
            return view('user::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function indexNoMerge(Request $request){
        try {
            $data['workers'] = DB::table('workers')->where('is_active', 1)->get();
            $data['projects'] = $this->projectService->getList(array_merge($request->all(), ['user_id' => auth('users')->id(), 'project_type' => 'all']));
            $data['users'] = DB::table('users')->where('status', 1)->where('company_id', auth()->guard('users')->user()->company_id)->get();
            return view('user::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function indexMark(Request $request){
        try {
            $data['workers'] = DB::table('workers')->where('is_active', 1)->get();
            $data['projects'] = $this->projectService->getList(array_merge($request->all(), ['user_id' => auth('users')->id(), 'project_type' => 'merge', 'type' => 1]));
            $data['users'] = DB::table('users')->where('status', 1)->where('company_id', auth()->guard('users')->user()->company_id)->get();
            return view('user::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function analyticsByYear(Request $request){
        try {
            $data['projects'] = $this->projectService->getList(array_merge($request->all(), ['user_id' => auth('users')->id()]));
            return  ResponseHelpers::showResponse($data['projects']);
        } catch (\Exception $e){
            return response()->json([]);
        }
    }

    public function all(Request $request)
    {
        try {
            $data['workers'] = DB::table('workers')->where('is_active', 1)->get();
            $data['projects'] = $this->projectService->getList($request->all());
            $data['users'] = DB::table('users')->where('status', 1)->get();
            return view('user::project.all', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function analyticsByYearAll(Request $request){
        try {
            $data['projects'] = $this->projectService->getList($request->all());
            return  ResponseHelpers::showResponse($data['projects']);
        } catch (\Exception $e){
            return response()->json([]);
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
            session()->flash('message', '図面依頼が完了しました。');
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
            session()->flash('update_project', 'Success');
            return redirect()->route('user.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function show($id)
    {
        try {
            $data['project'] = $this->projectService->findById($id);
            $data['users'] = $this->userService->pluckNameById();
            $data['workers'] = $this->workerService->pluckNameById();
            $data['childProjects'] = $this->projectService->getChildProject($id);
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
                session()->flash('message', '削除しました。');
                return redirect()->route('user.project.index_no_merge');
            }
            return  redirect()->route('user.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function updateAdditional(UpdateAdditionalProjectRequest $request, $id){
        try {
            if ($this->projectService->updateAdditional($id, $request->all())){
                session()->flash('update_project', 'Success');
            }
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function search(Request $request){
        try {
            return response()->json($this->projectService->search($request->all()));
        } catch (\Exception $e){
            return response()->json([]);
        }
    }

    public function addMessage(Request $request, $id){
        try {
            if ($this->projectService->addMessage($id, $request->all())){
                session()->flash('send_message_success', '送信しました。');
            }
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function done($id){
        try {
            $this->projectService->done($id);
            return redirect()->route('user.project.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }
}
