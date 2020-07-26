<?php


namespace Modules\Orders\Transformers;



use League\Fractal\TransformerAbstract;
use Modules\Orders\Entities\Models\Order;

class OrderTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'pharmacy', 'address', 'customer'
    ];

    public function transform(Order $item)
    {
        return [
            'id'                        => $item->id,
            'customer_name'                      => $item->customer->name,
            'amount'                      => $item->amount,
            "shipping_address" => $item->address,
            "delivery_charge" => $item->delivery_charge,
            "delivery_type" => $item->delivery_type,
            "payment_type" => $item->payment_type,
            "delivery_time" => $item->delivery_time,
            "status" => $item->status,
        ];
    }

    public function includePharmacy(Order $item)
    {

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
