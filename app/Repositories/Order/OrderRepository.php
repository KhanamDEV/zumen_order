<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 22/05/2022
 * Time: 09:30
 */


namespace App\Repositories\Order;


use App\Model\Order;

class OrderRepository implements OrderRepositoryInterface
{
    private $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        return $this->model->insertGetId($data);
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function find($data)
    {
        $query = $this->model->with(['project', 'worker', 'project.user']);
        if (!empty($data['id'])) $query = $query->where('id', $data['id']);
        if (!empty($data['project_id'])) $query = $query->where('project_id', $data['project_id']);
        if (!empty($data['worker_id'])) $query = $query->where('worker_id', $data['worker_id']);
        return $query->first();
    }

    public function getList($data)
    {
        $query = $this->model->with(['project', 'worker', 'project.user']);
        $query = $query->whereNotNull('worker_id');
        if (!empty($data['worker_id'])) $query->where('worker_id', $data['worker_id']);
        if (!empty($data['name'])) $query->whereHas('project', function ($query) use ($data){
            $query->where('name', 'like', '%' . $data['name'] . '%');
        });
        if (!empty($data['type'])) $query->whereHas('project', function ($query) use ($data){
            $query->where('type', $data['type']);
        });
        if (!empty($data['status'])){
            if ($data['status'] == 4){
                $query->whereHas('project', function ($query) use ($data){
                    $query->where('importunate', 1);
                });
            } else{
                $query->where('status', $data['status']);
            }
        }
        if (!empty($data['start_date'])) $query->whereHas('project', function ($query) use ($data){
            $query->whereDate('delivery_date', '>=', $data['start_date']);
        });
        if (!empty($data['end_date'])) $query->whereHas('project', function ($query) use ($data){
            $query->whereDate('delivery_date', '<=', $data['end_date']);
        });
        if (!empty($data['order_created_start'])) $query->whereDate('created_at', '>=', $data['order_created_start']);
        if (!empty($data['order_created_end'])) $query->whereDate('created_at', '<=', $data['order_created_end']);
        if (!empty($data['finish_day_start'])) $query->whereDate('finish_day', '>=', $data['finish_day_start']);
        if (!empty($data['finish_day_end'])) $query->whereDate('finish_day', '<=', $data['finish_day_end']);
        if (!empty($data['user_id'])) $query->whereHas('project', function ($query) use ($data){
           $query->where('user_id', $data['user_id']);
        });
        if (!empty($data['project_created_start'])){
            $query->whereHas('project', function ($query) use ($data){
                $query->whereDate('created_at', '>=', $data['project_created_start']);
            });
        }
        if (!empty($data['project_created_end'])){
            $query->whereHas('project', function ($query) use ($data){
                $query->whereDate('created_at', '<=', $data['project_created_end']);
            });
        }
        $query = $query->orderBy('created_at', 'DESC');
        if (!empty($data['per_page'])) return  $query->paginate($data['per_page']);
        return $query->get();
    }

    public function delete($data)
    {
        $query = $this->model;
        if (!empty($data['id'])) $query = $query->where('id', $data['id']);
        if (!empty($data['project_id'])) $query = $query->where('project_id', $data['project_id']);
        return $query->delete();
    }
}
