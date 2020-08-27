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
    public function all($request)
    {
        $products = Product::query();

        if ($request->has('form_id')) {
            $products->where('form_id', $request->get('form_id'));
        }

        if ($request->has('medicine') && $request->get('medicine')) {
            $medicine = $request->get('medicine');
            $products->where('name', 'LIKE', "%$medicine%");
        }

        if ($request->has('brand') && $request->get('brand')) {
            $brand = $request->get('brand');
            $products->where('name', 'LIKE', "%$brand%");
        }

        if ($request->has('generic') && $request->get('generic')) {
            $genericName = $request->get('generic');
            $generic = Generic::where('name', 'LIKE', "%$genericName%")->get()->pluck('id')->toArray();
            $products->whereIn('generic_id', $generic);
        }

        if ($request->has('company') && $request->get('company')) {
            $companyName = $request->get('company');
            $company = Company::where('name', 'LIKE', "%$companyName%")->get()->pluck('id')->toArray();
            $products->whereIn('company_id', $company);
        }
        
        return $products->with('productAdditionalInfo', 'form', 'category', 'generic', 'company', 'primaryUnit')
            ->paginate($request->get('per_page') ? $request->get('per_page') : config('subidha.item_per_page'));
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
            'primary_unit_id',
            'is_prescripted',
            'is_pre_order',
            'min_order_qty',
            'strength'
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
            'description' => $request->description
            
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

        if (isset($request->is_prescripted)) {
            $product->is_prescripted = $request->is_prescripted;
        }

        if (isset($request->is_pre_order)) {
            $product->is_pre_order = $request->is_pre_order;
        }

        if (isset($request->min_order_qty)) {
            $product->min_order_qty = $request->min_order_qty;
        } 
        
        if (isset($request->strength)) {
            $product->strength = $request->strength;
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
        
        if (isset($request->description)) {
            $productInfo->description = $request->description;
        }
        
        $productInfo->save();
        return $product;

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

    public function getRelatedProductByProductId($id)
    {
        $product = Product::find($id)->first();

        return Product::where('generic_id', $product->generic_id)->get();

    }
}
