<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 16:31
 */


namespace App\Repositories\Project;


interface ProjectRepositoryInterface
{
    public function store($data);

    public function getList($data);

    public function findById($id, $data = []);

    public function update($id, $data);

    public function delete($id);

    public function getLastProjectByCompany($users);

    public function getChildProject($parentProjectId);

}
