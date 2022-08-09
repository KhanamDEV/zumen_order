<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 06/08/2022
 * Time: 20:00
 */


namespace App\Services\Admin;



use App\Repositories\Company\CompanyRepositoryInterface;

class CompanyService
{
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getList($data = []){
        return $this->companyRepository->getList($data);
    }

    public function store($data){
        $dataInsert = [
            'name' => $data['name'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->companyRepository->store($dataInsert);
    }

    public function findById($id){
        return $this->companyRepository->findByData(['id' => $id]);
    }

    public function update($id, $data){
        $dataUpdate = [
            'name' => $data['name'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->companyRepository->update($id, $dataUpdate);
    }
}
