<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 13:40
 */


namespace App\Repositories\User;


interface UserRepositoryInterface
{
    public function update($id, $data);

    public function getList($data);

    public function findById($id);

    public function store($data);

    public function delete($id);

}
