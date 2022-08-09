<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\Admin\CompanyService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\CreateCompanyRequest;

class CompanyController extends Controller
{

    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request)
    {
        try {
            $data['companies'] = $this->companyService->getList($request->all());
            return  view('admin::company.index', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function create()
    {
        try {
            return view('admin::company.create');
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function store(CreateCompanyRequest $request)
    {
        try {
            if (!$this->companyService->store($request->all())){
                return redirect()->back();
            }
            session()->flash('message', 'アカウントを作成しました');
            return redirect()->route('admin.company.index');
        } catch (\Exception $e){
            abort(500);
        }
    }



    public function edit($id)
    {
        try {
            $data['company'] = $this->companyService->findById($id);
            return view('admin::company.edit', compact('data'));
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function update(CreateCompanyRequest $request, $id)
    {
        try {
            $this->companyService->update($id,$request->all());
            return redirect()->back();
        } catch (\Exception $e){
            abort(500);
        }
    }


    public function destroy($id)
    {
        //
    }
}
