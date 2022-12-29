<?php

namespace Modules\Worker\Http\Controllers;

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
            $data['users'] = DB::table('users')->get();
            $data['projects'] = $this->projectService->getList($request->all());
            $data['workers'] = $this->workerService->getList();
            $data['companies'] = $this->companyService->pluck();
            return view('worker::project.index', compact('data'));
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
            return view('worker::project.show', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function doProject($id){
        try {
            if ($this->projectService->doProject($id)){
                return redirect()->route('worker.project.index');
            }
            return  redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }



}
