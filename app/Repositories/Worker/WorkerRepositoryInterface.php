<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 22/05/2022
 * Time: 11:49
 */


namespace App\Repositories\Worker;


interface WorkerRepositoryInterface
{
    public function update($id, $data);

    public function getList($data = []);

    public function findById($id);

    public function store($data);

    public function delete($id);
}
