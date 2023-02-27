<?php


namespace Modules\Products\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Model\ProductAdditionalInfo;

class ProductAdditionalInfoTransformer extends TransformerAbstract
{
    public function transform(ProductAdditionalInfo $product)
    {
        return [
            'id' => $product->id,
            'product_id' => $product->product_id,
            'administration' => $product->administration,
            'precaution' => $product->precaution,
            'indication' => $product->indication ,
            'contra_indication' => $product->contra_indication,
            'side_effect' => $product->side_effect,
            'mode_of_action' => $product->mode_of_action,
            'interaction' => $product->interaction,
            'adult_dose' => $product->adult_dose,
            'child_dose' => $product->child_dose,
            'renal_dose' => $product->renal_dose,
            'description' => $product->description,
        ];
    }

}
