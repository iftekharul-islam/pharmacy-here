<?php

namespace Modules\Products\Transformers;

use Modules\Products\Entities\Model\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'productAdditionalInfo', 'form', 'category', 'generic', 'category', 'primaryUnit', 'company'
    ];

    /**
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'status' => $product->status,
            'trading_price' => $product->trading_price,
            'purchase_price' => $product->purchase_price,
            'unit' => $product->unit,
            'is_saleable' => $product->is_saleable,
            'conversion_factor' => $product->conversion_factor,
            'type' => $product->type,
            'form_id' => $product->form_id,
            'category_id' => $product->category_id,
            'generic_id' => $product->generic_id,
            'manufacturing_company_id' => $product->manufacturing_company_id,
            'primary_unit_id' => $product->primary_unit_id,
            'is_prescripted' => $product->is_prescripted,
            'is_pre_order' => $product->is_pre_order,
            'min_order_qty' => $product->min_order_qty,
            'strength' => $product->strength,
        ];
    }

    public function includeProductAdditionalInfo(Product $product)
    {
        if ($product->productAdditionalInfo != null) {
            return $this->item($product->productAdditionalInfo, new ProductAdditionalInfoTransformer());
        }
        return null;
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

    public function includePrimaryUnit(Product $product)
    {
        return $this->item($product->primaryUnit, new UnitTransformer());
    }


}
