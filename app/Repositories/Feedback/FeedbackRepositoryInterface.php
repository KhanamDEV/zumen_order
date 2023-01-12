<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 07/08/2022
 * Time: 15:56
 */


namespace App\Repositories\Feedback;


interface FeedbackRepositoryInterface
{
    public function store($data);

    public function delete($id);

    public function findById($id);

    public function getList($data);

}
