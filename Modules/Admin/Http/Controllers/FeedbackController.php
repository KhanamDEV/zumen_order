<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\Admin\FeedbackService;
use App\Services\User\ProjectService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    private $feedbackService;

    private $projectService;

    public function __construct(FeedbackService $feedbackService, ProjectService  $projectService)
    {
        $this->feedbackService = $feedbackService;
        $this->projectService = $projectService;
    }

    public function show($projectId, $id){
        try {
            $data['feedback'] = $this->projectService->findById($id);
            return view('admin::project.feedback.detail', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function update(Request $request){
        try {
            DB::table('feedbacks')->where('id', $request->route('id'))->update([
                'documents' => $request->get('documents'),
                'documents_of_worker' => $request->get('documents_of_worker')
            ]);
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }
}
