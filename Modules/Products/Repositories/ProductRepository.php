<?php


namespace Modules\Products\Repositories;


use Modules\Products\Entities\Model\Company;

class ProductRepository
{
    public function allCompany()
    {
        return Company::all();
    }

}
