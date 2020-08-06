<?php


namespace Modules\Orders\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Products\Transformers\ProductTransformer;

class OrderItemTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'product'
    ];

    public function transform(OrderItems $item)
    {
        return [
            'id'                        => $item->id,
            'quantity'                  => $item->quantity,
            'rate'                      => $item->rate,

        ];
    }

    public function includeProduct(OrderItems $item)
    {
        return $this->item($item->product, new ProductTransformer());
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

