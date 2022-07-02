<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 13:40
 */


namespace App\Repositories\User;


use App\Model\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function getList($data)
    {
        $query = DB::table('users');
        if (!empty($data['email'])) $query->where('email', $data['email']);
        if (!empty($data['last_name'])) $query->where('last_name', 'like', '%'.$data['last_name'].'%');
        $query->orderBy('created_at', 'DESC');
        if (!empty($data['per_page'])) return $query->paginate($data['per_page']);
        return $query->get();
    }

    public function findById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function store($data)
    {
        return $this->model->insertGetId($data);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
