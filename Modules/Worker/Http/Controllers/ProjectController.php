<?php

namespace Modules\Worker\Http\Controllers;

use App\Services\Worker\ProjectService;
use App\Services\Worker\WorkerService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    private $projectService;
    private $workerService;
    public function __construct(ProjectService $projectService, WorkerService $workerService)
    {
        $this->projectService = $projectService;
        $this->workerService = $workerService;
    }

    public function index(Request $request)
    {
        try {
            $data['users'] = DB::table('users')->get();
            $data['projects'] = $this->projectService->getList($request->all());
            $data['workers'] = $this->workerService->getList();
            return view('worker::project.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function show($id)
    {
        try {
            $data['project'] = $this->projectService->findById($id);
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
