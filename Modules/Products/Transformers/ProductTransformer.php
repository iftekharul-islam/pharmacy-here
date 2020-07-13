<?php

namespace Modules\Products\Transformers;

use Modules\Products\Entities\Model\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
//    public function __construct($includes = [])
//    {
//        if(!empty($includes)) {
//            $this->defaultIncludes = array_merge($this->defaultIncludes, $includes);
//        }
//    }

    protected $availableIncludes = [
        'productAdditionalInfo', 'form', 'company', 'generic', 'category'
    ];

    public function transform(Product $product)
    {
        return [
            'id'                        => $product->id,
            'name'                      => $product->name,
            'status'                    => $product->status,
            'trading_price'             => $product->trading_price ,
            'purchase_price'            => $product->purchase_price,
            'unit'                      => $product->unit,
            'is_saleable'               => $product->is_saleable,
            'conversion_factor'         => $product->conversion_factor,
            'type'                      => $product->type,
            'form_id'                   => $product->form_id,
            'category_id'               => $product->category_id,
            'generic_id'                => $product->generic_id,
            'manufacturing_company_id'  => $product->manufacturing_company_id,
            'primary_unit_id'           => $product->primary_unit_id
        ];
    }

    public function includeProductAdditionalInfo(Product $product)
    {
        return $this->item($product->productAdditionalInfo, new ProductAdditionalInfoTransformer());
    }

    public function includeForm(Product $product)
    {
        return $this->item($product->form, new FormTransformer());
    }

    public function includeCompany(Product $product)
    {
        return $this->item($product->company, new CompanyTransformer());
    }

    public function includeGeneric(Product $product)
    {
        return $this->item($product->generic, new GenericTransformer());
    }

    public function includeCategory(Product $product)
    {
        return $this->item($product->category, new CategoryTransformer());
    }


}
