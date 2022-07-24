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
            $this->orderService->update($id, $request->all());
            return back();
        } catch (\Exception $e){
            abort(500);
        }
    }

    public function leaveProject($id){
        try {
            $this->orderService->leaveProject($id);
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

}
