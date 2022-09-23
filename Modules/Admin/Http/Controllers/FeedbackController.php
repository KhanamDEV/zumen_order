<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\Admin\FeedbackService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

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
            dd($e);
        }
    }
}
