<?php


namespace Modules\Products\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Model\Company;

class CompanyTransformer extends TransformerAbstract
{
    public function transform(Company $company)
    {
        return [
            'id'                        => $company->id,
            'name'                      => $company->name,
            'status'                    => $company->status,
        ];
    }

}
