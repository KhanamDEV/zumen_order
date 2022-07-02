<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 24/05/2022
 * Time: 09:54
 */

namespace App\Repositories\Admin;

use App\Model\Admin;

class AdminRepository implements AdminRepositoryInterface
{

    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function getList($data = [])
    {
        return $this->model->get();
    }
}
