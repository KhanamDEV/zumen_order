<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 28/12/2022
 * Time: 22:31
 */


namespace App\Services\Worker;


use App\Repositories\Company\CompanyRepositoryInterface;

class CompanyService
{
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function pluck(){
        return $this->companyRepository->pluck();
    }
}
