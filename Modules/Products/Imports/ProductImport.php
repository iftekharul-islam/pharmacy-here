<?php


namespace Modules\Products\Imports;


use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Products\Entities\Model\Category;
use Modules\Products\Entities\Model\Company;
use Modules\Products\Entities\Model\Form;
use Modules\Products\Entities\Model\Generic;
use Modules\Products\Entities\Model\Product;
use Modules\Products\Entities\Model\ProductAdditionalInfo;
use Modules\Products\Entities\Model\Unit;

class ProductImport implements ToCollection, WithHeadingRow
{

    use Importable;

//    public function model(array $row)
//    {
////        dd($row);
//        return new Product([
//            'company' => $row[1],
//            'name' => $row[2],
//            'generic_id' => $row[3],
//            'strength' => $row[4],
//            'form_id' => 1,  // Dosage description in excel
//            'packSize' => $row[6],
//            'price' => $row[7],
//            'rx' => $row[8],
//            'preOrder' => $row[9],
//        ]);
//    }

//    public function headingRow(): int
//    {
//        return 1;
//    }

    public function collection(Collection $rows)
    {
//        dd($rows[0]);

        foreach ($rows as $row) {
//            dd('processing'. json_encode($row));

            if ($row['sl'] != null) {

//                if (!isset($row['generic'])) {
//                    continue;
//                }
                $genericId = $this->getGenericId($row['generic']);
                $companyId = $this->getCompanyId($row['company']);
                $formId = $this->getFormId($row['dosage_description']);
                $unitId = $this->getUnitId($row['pack_size']);
                $categoryId = $this->getCategoryId();
                $isPrescripted = $this->getIsPrescripted($row['rx_only']);
                $isPreOrder = $this->getIsPreOrder($row['pre_order']);


                $data['name'] = $row['brand']; // Brand in excel
                $data['manufacturing_company_id'] = $companyId;
                $data['generic_id'] = $genericId;
                $extra = [
                    'category_id' => $categoryId,
                    'primary_unit_id' => $unitId,
                    'form_id' => $formId, // Dosage description in excel
                    'strength' => $row['strength'],
                    'purchase_price' => $row['priceunit'],
                    'is_saleable' => true,
                    'is_prescripted' => $isPrescripted,
                    'is_pre_order' => $isPreOrder,
                    'min_order_qty' => 1
                ];

                $data = array_merge($data, $extra);
//            dd($data);

                $newProduct = Product::create($data);

                $productInfo = [
                    'product_id' => $newProduct->id,
                ];

                ProductAdditionalInfo::create($productInfo);
            }
        }

    }

    private function getGenericId($name)
    {
        $data = Generic::where('name', $name)->first();

        if ($data == null) {
            $data = Generic::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
//            echo 'New Data ggg'. json_encode($data);
        }
        return $data->id;

    }

    private function getFormId($name)
    {
        $data = Form::where('name', $name)->first();

        if ($data == null) {
            $data = Form::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
//            echo 'New Data fff'. $data->id;
        }
        return $data->id;
    }

    private function getCompanyId($name)
    {
        $data = Company::where('name', $name)->first();

        if ($data == null) {
            $data = Company::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
//            echo 'New Data ccc'. $data->id;
        }
        return $data->id;
    }

    private function getUnitId($name)
    {
        $data = Unit::where('name', $name)->first();

        if ($data == null) {
            $data = Unit::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
//            echo 'New Data uuu'. $data->id;
        }
        return $data->id;
    }

    private function getCategoryId()
    {
        $name = 'Medicine';
        $data = Category::where('name', $name)->first();

        if ($data == null) {
            $data = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
//            echo 'New Data uuu'. $data->id;
        }
        return $data->id;
    }


    private function getIsPrescripted($value)
    {
        if ($value != null && $value === 'OTC') {
            return 1;
        }
        return 0;
    }

    private function getIsPreOrder($value)
    {
        if ($value != null && $value === 'yes') {
            return 1;
        }
        return 0;
    }



}
