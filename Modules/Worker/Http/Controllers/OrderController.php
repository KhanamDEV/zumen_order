<?php

namespace Modules\Worker\Http\Controllers;

use App\Services\Worker\OrderService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        try {
            $data['users'] = DB::table('users')->get();
            $data['orders'] = $this->orderService->getList($request->all());
            return view('worker::order.index', compact('data'));
        } catch (\Exception $e){
            dd($e);
            abort(500);
        }
    }


    public function show($id)
    {
        try {
            $data['order'] = $this->orderService->findById($id);
            return view('worker::order.show', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $document = json_decode(\request()->get('documents'));
            if (empty($document)){
                session()->flash('error', '図面をアップロードしてください。');
                return redirect()->back();
            }
            $this->orderService->update($id, $request->all());
            return back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function leaveProject($id){
        try {
            $this->orderService->leaveProject($id);
            session()->flash('message', '中止しました。');
            return redirect()->route('worker.order.index');
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function doneProject($id){
        try {
            $this->orderService->doneProject($id);
            return redirect()->route('worker.order.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function requestConfirmation($id){
        try {
            $this->orderService->requestConfirmation($id);
            return redirect()->route('worker.order.show', ['id' => $id]);
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function addMessage(Request $request, $id){
        try {
            if ($this->orderService->addMessage($id, $request->all())){
                session()->flash('send_message_success', '送信しました。');
            }
            return redirect()->back();
        } catch (\Exception $e){
            dd($e);
            abort(500);
        }
    }

}
