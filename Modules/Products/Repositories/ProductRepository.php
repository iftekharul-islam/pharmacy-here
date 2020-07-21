<?php


namespace Modules\Products\Repositories;

use Dingo\Api\Exception\StoreResourceFailedException;
use Modules\Products\Entities\Model\Category;
use Modules\Products\Entities\Model\Company;
use Modules\Products\Entities\Model\Form;
use Modules\Products\Entities\Model\Generic;
use Modules\Products\Entities\Model\Product;
use Modules\Products\Entities\Model\ProductAdditionalInfo;
use Modules\Products\Entities\Model\Unit;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductRepository
{
    public function all()
    {
        return Product::with('productAdditionalInfo', 'form', 'category', 'generic', 'company', 'primaryUnit')
            ->get();
    }

    public function get($id)
    {
        return Product::with('productAdditionalInfo', 'form', 'category', 'generic', 'company', 'primaryUnit')
            ->find($id);

    }

    public function create($request)
    {
        $productData = $request->only(
            'name',
            'status',
            'trading_price',
            'purchase_price',
            'unit',
            'is_saleable',
            'conversion_factor',
            'type',
            'form_id',
            'category_id',
            'generic_id',
            'manufacturing_company_id',
            'primary_unit_id'
        );

        $newProduct = Product::create($productData);

        if (!$newProduct) {
            throw new StoreResourceFailedException('Product create failed');
        }

        $productInfo = [
            'product_id' => $newProduct->id,
            'administration' => $request->administration,
            'precaution' => $request->precaution,
            'indication' => $request->indication,
            'contra_indication' => $request->contra_indication,
            'side_effect' => $request->side_effect,
            'mode_of_action' => $request->mode_of_action,
            'interaction' => $request->interaction,
            'adult_dose' => $request->adult_dose,
            'child_dose' => $request->child_dose,
            'renal_dose' => $request->renal_dose,
        ];

        return ProductAdditionalInfo::create($productInfo);

    }

    public function update($request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        if (isset($request->name)) {
            $product->name = $request->name;
        }

        if (isset($request->status)) {
            $product->status = $request->status;
        }

        if (isset($request->trading_price)) {
            $product->trading_price = $request->trading_price;
        }

        if (isset($request->purchase_price)) {
            $product->purchase_price = $request->purchase_price;
        }

        if (isset($request->unit)) {
            $product->unit = $request->unit;
        }

        if (isset($request->is_saleable)) {
            $product->is_saleable = $request->is_saleable;
        }

        if (isset($request->conversion_factor)) {
            $product->conversion_factor = $request->conversion_factor;
        }

        if (isset($request->type)) {
            $product->type = $request->type;
        }

        if (isset($request->form_id)) {
            $product->form_id = $request->form_id;
        }

        if (isset($request->category_id)) {
            $product->category_id = $request->category_id;
        }

        if (isset($request->generic_id)) {
            $product->generic_id = $request->generic_id;
        }

        if (isset($request->manufacturing_company_id)) {
            $product->manufacturing_company_id = $request->manufacturing_company_id;
        }

        if (isset($request->name)) {
            $product->primary_unit_id = $request->primary_unit_id;
        }

        $product->save();

        $productInfo = ProductAdditionalInfo::where('product_id', $id)->first();

        if (isset($request->administration)) {
            $productInfo->administration = $request->administration;
        }

        if (isset($request->precaution)) {
            $productInfo->precaution = $request->precaution;
        }

        if (isset($request->indication)) {
            $productInfo->indication = $request->indication;
        }

        if (isset($request->contra_indication)) {
            $productInfo->contra_indication = $request->contra_indication;
        }

        if (isset($request->side_effect)) {
            $productInfo->side_effect = $request->side_effect;
        }

        if (isset($request->mode_of_action)) {
            $productInfo->mode_of_action = $request->mode_of_action;
        }

        if (isset($request->interaction)) {
            $productInfo->interaction = $request->interaction;
        }

        if (isset($request->adult_dose)) {
            $productInfo->adult_dose = $request->adult_dose;
        }

        if (isset($request->child_dose)) {
            $productInfo->child_dose = $request->child_dose;
        }

        if (isset($request->renal_dose)) {
            $productInfo->renal_dose = $request->renal_dose;
        }

        return $productInfo->save();

    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found');
        }

        return $product->delete();
    }

    public function getAllCategory()
    {
        return Category::all();
    }

    public function getAllGeneric()
    {
        return Generic::all();
    }

    public function getAllForm()
    {
        return Form::all();
    }

    public function getAllCompany()
    {
        return Company::all();
    }

    public function getAllUnit()
    {
        return Unit::all();
    }
}
