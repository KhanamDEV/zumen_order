<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\FeedbackService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CreateFeedbackRequest;

class FeedbackController extends Controller
{

    private $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function index()
    {
        return view('user::index');
    }


    public function store(CreateFeedbackRequest $request)
    {
        try {
            $this->feedbackService->store($request->all());
            session()->flash('message', '図面依頼が完了しました。');
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function show(Request $request)
    {
        try{
            $data['feedback'] = $this->feedbackService->findById($request->id);
            return view('user::project.feedback.detail', compact('data'));
        } catch (\Exception $e){
            return response()->json([]);
        }
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        try {
            $this->feedbackService->delete($id);
            session()->flash('message', '削除しました。');
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }
}
