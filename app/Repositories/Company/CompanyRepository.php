<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 06/08/2022
 * Time: 19:49
 */


namespace App\Repositories\Company;


use App\Model\Company;

class CompanyRepository implements CompanyRepositoryInterface
{

    private $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function getList($data)
    {
        $query = $this->model;
        if (!empty($data['name'])) $query = $query->where('name', 'like', '%' . $data['name'] . '%');
        return $query->get();
    }

    public function findByData($data)
    {
        $query = $this->model;

        return $query->first();
    }

    public function store($data)
    {
        return $this->model->insert($data);
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function pluck()
    {
        return $this->model->pluck('name', 'id');
    }
}
