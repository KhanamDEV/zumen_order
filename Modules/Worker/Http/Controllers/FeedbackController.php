<?php

namespace Modules\Worker\Http\Controllers;

use App\Model\Project;
use App\Services\Worker\FeedbackService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FeedbackController extends Controller
{

    private $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function show($projectId, $id){
        try {
            $data['feedback'] = $this->feedbackService->findById($id);
            return view('worker::project.feedback.show', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }
}
