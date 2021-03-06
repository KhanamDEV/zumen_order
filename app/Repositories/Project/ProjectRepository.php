<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 16:31
 */


namespace App\Repositories\Project;


use App\Model\Project;

class ProjectRepository implements ProjectRepositoryInterface
{

    private $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        return $this->model->insertGetId($data);
    }

    public function getList($data)
    {
        $query = $this->model->with(['order', 'user']);
        if (!empty($data['user_id'])) $query = $query->where('user_id', $data['user_id']);
        if (!empty($data['name'])) $query = $query->where('name', 'like', '%' . $data['name'] . '%');
        if (!empty($data['owner'])) $query = $query->where('owner', 'like', '%' . $data['owner'] . '%');
        if (!empty($data['type'])) $query = $query->where('type', $data['type']);
        if (!empty($data['status'])){
            if ($data['status'] == 4){
                $query = $query->where('importunate', 1);
            } else{
                $query = $query->whereHas('order', function ($query) use ($data) {
                    $query->where('status', $data['status']);
                });
            }
        }
        if (!empty($data['worker_id'])) $query = $query->whereHas('order', function ($query) use ($data) {
             $query->where('worker_id', $data['worker_id']);
        });
        if (!empty($data['delivery_date'])) $query = $query->whereDate('delivery_date', '=', $data['delivery_date']);
        if(!empty($data['unexpired'])) $query = $query->whereDate('delivery_date', '>=', date('Y-m-d'));
        if (!empty($data['start_date'])) $query = $query->whereDate('delivery_date', '>=', $data['start_date']);
        if (!empty($data['end_date'])) $query = $query->whereDate('delivery_date', '<=', $data['end_date']);
        if (!empty($data['created_at_start'])) $query = $query->whereDate('created_at', '>=', $data['created_at_start']);
        if (!empty($data['created_at_end'])) $query = $query->whereDate('created_at', '<=', $data['created_at_end']);
        if (!empty($data['order_created_start'])) {
            $query = $query->whereHas('order', function ($query) use ($data){
               $query->whereNotNull('worker_id')->whereDate('created_at', '>=', $data['order_created_start']);
            });
        }
        if (!empty($data['order_created_end'])) {
            $query = $query->whereHas('order', function ($query) use ($data){
                $query->whereNotNull('worker_id')->whereDate('created_at', '<=', $data['order_created_end']);
            });
        }
        if (!empty($data['finish_day_start'])) {
            $query = $query->whereHas('order', function ($query) use ($data){
                $query->whereNotNull('worker_id')->whereDate('finish_day', '>=', $data['finish_day_start']);
            });
        }
        if (!empty($data['finish_day_end'])) {
            $query = $query->whereHas('order', function ($query) use ($data){
                $query->whereNotNull('worker_id')->whereDate('finish_day', '<=', $data['finish_day_end']);
            });
        }
        $query = $query->orderBy('created_at', 'DESC');
        if (!empty($data['per_page'])) {
            return $query->paginate($data['per_page']);
        }
        return $query->get();
    }

    public function findById($id, $data = [])
    {
        $query = $this->model->with(['order', 'user']);
        if (!empty($data['status'])) $query = $query->whereHas('order', function ($query) use ($data) {
            $query->where('status', $data['status']);
        });
        return $query->where('id', $id)->first();
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
