<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 07/08/2022
 * Time: 15:56
 */


namespace App\Repositories\Feedback;


use App\Model\Feedback;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    private $model;

    public function __construct(Feedback $model)
    {
        $this->model = $model;
    }

    public function store($data){
        return $this->model->insert($data);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function findById($id)
    {
        return $this->model->with(['worker', 'project', 'project.user'])->where('id', $id)->first();
    }

    public function getList($data)
    {
        $query = $this->model->with(['project', 'project.order', 'worker', 'project.user' => function($query) use ($data){
            if (!empty($data['auth_type']) && $data['auth_type'] == 'user'){
                $user = auth('users')->user();
                return $query->where('company_id', $user->company_id);
            }
        }]);
        if(!empty($data['company_id'])) $query = $query->whereHas('user', function ($subQuery) use($data){
            return $subQuery->where('company_id', $data['company_id']);
        });
        if (!empty($data['user_id'])) $query = $query->whereHas('project', function ($subQuery) use ($data){
            return $subQuery->where('user_id', $data['user_id']);
        });
        if (!empty($data['status']) && $data['status'] != 3) return  [];
        if (!empty($data['number'])) $query = $query->where('number', $data['number']);
        if (!empty($data['name'])){
            $query = $query->where('name', 'like', '%' . $data['name'] . '%')
                ->orWhere('owner', 'like', '%'.$data['name'].'%');
        }
        if (!empty($data['owner'])) $query = $query->where('owner', 'like', '%' . $data['owner'] . '%');
        if (!empty($data['type'])) $query = $query->where('type', $data['type']);

        if (!empty($data['worker_id'])) $query = $query->whereHas('project.order', function ($query) use ($data) {
            $query->where('worker_id', $data['worker_id']);
        });
        if (!empty($data['delivery_date'])) $query = $query->whereDate('delivery_date', '=', $data['delivery_date']);
        if(!empty($data['unexpired'])) $query = $query->whereDate('delivery_date', '>=', date('Y-m-d'));
        if (!empty($data['start_date'])) $query = $query->whereDate('delivery_date', '>=', $data['start_date']);
        if (!empty($data['end_date'])) $query = $query->whereDate('delivery_date', '<=', $data['end_date']);
        if (!empty($data['created_at_start'])) $query = $query->whereDate('project_created_at', '>=', $data['created_at_start']);
        if (!empty($data['created_at_end'])) $query = $query->whereDate('project_created_at', '<=', $data['created_at_end']);
        if (!empty($data['order_created_start'])) $query = $query->whereDate('order_created_at', '>=', $data['order_created_start']);
        if (!empty($data['order_created_end'])) $query = $query->whereDate('order_created_at', '<=', $data['order_created_end']);
        if (!empty($data['finish_day_start'])) $query = $query->whereDate('finish_day', '<=', $data['finish_day_start']);
        if (!empty($data['finish_day_end'])) $query = $query->whereDate('finish_day', '<=', $data['finish_day_end']);
        $query = $query->orderBy('created_at', 'DESC');
        if (!empty($data['per_page'])) {
            return $query->paginate($data['per_page']);
        }
        return $query->get();
    }
}
