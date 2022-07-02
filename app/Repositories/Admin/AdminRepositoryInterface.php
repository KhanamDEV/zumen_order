<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 24/05/2022
 * Time: 09:53
 */

namespace App\Repositories\Admin;

interface AdminRepositoryInterface
{
    public function update($id, $data);

    public function getList($data = []);
}
