<?php

namespace Modules\Worker\Http\Controllers;

use App\Model\Project;
use App\Services\Worker\FeedbackService;
use App\Services\Worker\ProjectService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FeedbackController extends Controller
{

    private $feedbackService;

    private $projectService;

    public function __construct(FeedbackService $feedbackService, ProjectService $projectService)
    {
        $this->feedbackService = $feedbackService;
        $this->projectService = $projectService;
    }

    public function show($projectId, $id){
        try {
            $data['feedback'] = $this->projectService->findById($id);
            return view('worker::project.feedback.show', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }
}
