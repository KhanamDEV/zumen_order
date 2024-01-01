<?php

namespace Modules\Worker\Http\Controllers;

use App\Helpers\ResponseHelpers;
use App\Services\Worker\CompanyService;
use App\Services\Worker\ProjectService;
use App\Services\Worker\UserService;
use App\Services\Worker\WorkerService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    private $projectService;
    private $workerService;
    private $userService;
    private $companyService;

    public function __construct(ProjectService $projectService, WorkerService $workerService, UserService $userService,
                                CompanyService $companyService)
    {
        $this->projectService = $projectService;
        $this->workerService = $workerService;
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    public function index(Request $request)
    {
        try {
            $data['users'] = DB::table('users')->where('status', 1)->get();
            $data['projects'] = $this->projectService->getList(array_merge($request->all(), ['project_type' => 'merge']));
            $data['workers'] = $this->workerService->getList();
            $data['companies'] = $this->companyService->pluck();
            return view('worker::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function indexNoMerge(Request $request)
    {
        try {
            $data['users'] = DB::table('users')->where('status', 1)->get();
            $data['projects'] = $this->projectService->getList($request->all());
            $data['workers'] = $this->workerService->getList();
            $data['companies'] = $this->companyService->pluck();
            return view('worker::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function indexMark(Request $request)
    {
        try {
            $data['users'] = DB::table('users')->where('status', 1)->get();
            $data['projects'] = $this->projectService->getList(array_merge($request->all(), ['project_type' => 'merge', 'type' => 1]));
            $data['workers'] = $this->workerService->getList();
            $data['companies'] = $this->companyService->pluck();
            return view('worker::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function analyticsByYear(Request $request){
        try {
            $data['projects'] = $this->projectService->getList(array_merge(\request()->all(), []));
            return  ResponseHelpers::showResponse($data['projects']);
        } catch (\Exception $e){
            return response()->json([]);
        }
    }

    public function show($id)
    {
        try {
            $data['project'] = $this->projectService->findById($id);
            $data['users'] = $this->userService->pluckNameById();
            $data['workers'] = $this->workerService->pluckNameById();
            $data['childProjects'] = $this->projectService->getChildProject($id);
            return view('worker::project.show', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function doProject($id){
        try {
            if ($this->projectService->doProject($id)){
                return redirect()->route('worker.project.show', ['id' => $id]);
            }
            return  redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }



}
