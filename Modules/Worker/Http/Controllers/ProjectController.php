<?php

namespace Modules\Worker\Http\Controllers;

use App\Services\Worker\ProjectService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

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
            $data['users'] = DB::table('users')->get();
            $data['projects'] = $this->projectService->getList($request->all());
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
