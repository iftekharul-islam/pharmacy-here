<?php


namespace Modules\Orders\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\Prescription\Transformers\PrescriptonTransformer;
use Modules\Products\Transformers\ProductTransformer;

class OrderPrescriptionTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'prescription'
    ];

    public function transform(OrderPrescription $item)
    {
        logger('prescripton: '. $item);
        return [
            'id'            => $item->id,
            'doctor'        => $item->doctor_name,
            'prescription_date' => $item->prescription_date,
            'url'           => $item->url
        ];
    }

    public function includePrescription(OrderPrescription $item)
    {
        return $this->item($item->prescription, new PrescriptonTransformer());
    }

//    public function includeProductAdditionalInfo(Product $product)
//    {
//        return $this->item($product->productAdditionalInfo, new ProductAdditionalInfoTransformer());
//    }
//
//    public function includeForm(Product $product)
//    {
//        return $this->item($product->form, new FormTransformer());
//    }
//
//    public function includeCompany(Product $product)
//    {
//        return $this->item($product->company, new CompanyTransformer());
//    }
//
//    public function includeGeneric(Product $product)
//    {
//        return $this->item($product->generic, new GenericTransformer());
//    }
//
//    public function includeCategory(Product $product)
//    {
//        return $this->item($product->category, new CategoryTransformer());
//    }
//
//    public function includePrimaryUnit(Product $product)
//    {
//        return $this->item($product->primaryUnit, new UnitTransformer());
//    }


}

