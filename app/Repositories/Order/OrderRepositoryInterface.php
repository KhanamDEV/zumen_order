<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 22/05/2022
 * Time: 09:30
 */


namespace App\Repositories\Order;


interface OrderRepositoryInterface
{
    public function store($data);

    public function update($id, $data);

    public function find($data);

    public function getList($data);

    public function delete($data);
}
