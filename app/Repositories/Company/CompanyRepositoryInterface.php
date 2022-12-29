<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 06/08/2022
 * Time: 19:49
 */


namespace App\Repositories\Company;


interface CompanyRepositoryInterface
{
    public function getList($data);

    public function findByData($data);

    public function store($data);

    public function update($id ,$data);

    public function pluck();
}
