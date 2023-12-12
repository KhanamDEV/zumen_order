<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data = DB::table('projects')->where('user_id', 7)
        ->whereNotNull('parent_project_id')->get();
    dd($data);
//    return redirect()->route('user.login');
    $feedbacks = DB::table('feedbacks')
        ->select('feedbacks.*', 'projects.user_id', 'projects.number as project_number')
        ->leftJoin('projects', 'projects.id', '=', 'feedbacks.project_id')
        ->orderBy('id', 'DESC')->get();
    DB::beginTransaction();
    try {
        foreach ($feedbacks as $feedback){
            $dataInsertProject = [
                'user_id' => $feedback->user_id,
                'name' => $feedback->name,
                'owner' => $feedback->owner,
                'type'  => $feedback->type,
                'delivery_date' => $feedback->delivery_date,
                'importunate' => $feedback->importunate,
                'note' => $feedback->note,
                'other_information' => $feedback->other_information,
                'url' => $feedback->url,
                'documents' => $feedback->documents,
                'created_at' => $feedback->created_at,
                'updated_at' => null,
                'postal_code' => $feedback->postal_code,
                'additional' => $feedback->additional,
                'url_additional' => $feedback->url_additional,
                'documents_additional' => $feedback->documents_additional,
                'messages' => $feedback->messages,
                'control_number' => $feedback->control_number,
                'number' => $feedback->project_number,
                'parent_project_id' => $feedback->project_id,
            ];
            $projectId = DB::table('projects')->insertGetId($dataInsertProject);
            $dataOrder = [
                'project_id' => $projectId,
                'worker_id' => $feedback->worker_id,
                'status' => 3,
                'finish_day' => $feedback->finish_day,
                'documents' => $feedback->documents_of_worker,
                'created_at' => $feedback->order_created_at
            ];
            DB::table('orders')->insert($dataOrder);
        }
        DB::commit();
    } catch (Exception $e){
        DB::rollBack();
        dd($e);
    }

    dd('ok');
    return redirect()->route('user.login');
});
