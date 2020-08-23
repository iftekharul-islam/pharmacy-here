<?php

namespace  Modules\Prescription\Transformers;

use Modules\Products\Entities\Model\Prescripton;
use League\Fractal\TransformerAbstract;
use Modules\Prescription\Entities\Models\Prescription;

class PrescriptonTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'productAdditionalInfo', 'form', 'category', 'generic', 'category', 'primaryUnit', 'company'
    ];

    public function transform(Prescription $prescription)
    {

        return [
            'id'                => $prescription->id,
            'doctor_name'       => $prescription->doctor_name,
            'prescription_date' => $prescription->prescription_date,
            'url'               => $prescription->url ,
            'user_id'           => $prescription->user_id,
            
        ];
    }

    // public function includeProductAdditionalInfo(Product $product)
    // {
    //     return $this->item($product->productAdditionalInfo, new ProductAdditionalInfoTransformer());
    // }

    // public function includeForm(Product $product)
    // {
    //     return $this->item($product->form, new FormTransformer());
    // }

    // public function includeCompany(Product $product)
    // {
    //     return $this->item($product->company, new CompanyTransformer());
    // }

    // public function includeGeneric(Product $product)
    // {
    //     return $this->item($product->generic, new GenericTransformer());
    // }

    // public function includeCategory(Product $product)
    // {
    //     return $this->item($product->category, new CategoryTransformer());
    // }

    // public function includePrimaryUnit(Product $product)
    // {
    //     return $this->item($product->primaryUnit, new UnitTransformer());
    // }


}
