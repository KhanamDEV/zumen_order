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
}
