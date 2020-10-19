<?php


namespace App\Imports;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
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

//        dd(count($rows));

        echo "----Importing products----\n";

//        DB::statement("SET foreign_key_checks=0");
//        Generic::truncate();
//        Form::truncate();
//        Company::truncate();
//        Unit::truncate();
//        Category::truncate();
//        Product::truncate();
//        ProductAdditionalInfo::truncate();
//        DB::statement("SET foreign_key_checks=1");

        foreach ($rows as $row) {
//            dd('processing'. json_encode($row));

            if ($row['sl'] != null && $row['brand'] != null) {

                $companyId = $this->getCompanyId($row['company']);
                $genericId = $this->getGenericId($row['generic']);
                $formId = $this->getFormId($row['dosage_description']);
//                $unitId = $this->getUnitId($row['pack_size']);
                $unitId = $this->getUnitId($row);
                $categoryId = $this->getCategoryId();
                $isPreOrder = $this->getIsPreOrder($row['pre_order']);
                $price = $this->getPrice($row['priceunit']);

                if ($row['sl'] < 4550) {
                    $isPrescripted = $this->getIsPrescripted($row['rx_only']);
                }

                $data['name'] = $row['brand']; // Brand in excel
                $data['manufacturing_company_id'] = $companyId;
                $data['generic_id'] = $genericId;
                $extra = [
                    'category_id' => $categoryId,
                    'primary_unit_id' => $unitId,
                    'form_id' => $formId, // Dosage description in excel
                    'strength' => $row['strength'],
                    'purchase_price' => $price,
                    'is_saleable' => true,
                    'is_prescripted' => $isPrescripted,
                    'is_pre_order' => $isPreOrder,
                    'min_order_qty' => 1
                ];

                $data = array_merge($data, $extra);

                $newProduct = Product::create($data);

                $productInfo = [
                    'product_id' => $newProduct->id,
                ];

                ProductAdditionalInfo::create($productInfo);


                echo "Serial: " . $row['sl'] . "\n";
            }

        }

        echo "----Done----\n";

    }

//    public function chunkSize(): int
//    {
//        return 10;
//    }

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
        if ($name == null) {

            $name = 'orphan';
            $orphan = Form::where('name', $name)->first();

            if ($orphan == null) {
                $orphan = Form::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'status' => true,
                ]);
            }
            return $orphan->id;
        }

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
        if ($name == null) {

            $name = 'orphan';
            $orphan = Company::where('name', $name)->first();

            if ($orphan == null) {
                $orphan = Company::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'status' => true,
                ]);
            }
            return $orphan->id;
        }

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

    private function getUnitId($row)
    {
        $name = $row['pack_size'];
        $form = $row['dosage_description'];

        if ($name == null && $form == null) {

            $name = 'orphan';
            $orphan = Unit::where('name', $name)->first();

            if ($orphan == null) {
                $orphan = Unit::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'status' => true,
                ]);
            }
            return $orphan->id;
        }

        if ($name == null && $form != null) {
            $name = '1 ' . $form;
            $item = Unit::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
            return $item->id;
        }

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
        if ($value != null && $value === 'OTC' || $value === 'otc') {
            return 0;
        }
        return 1;
    }

    private function getIsPreOrder($value)
    {
        if ($value != null && $value == 'Yes' || $value === 'yes') {
            return 1;
        }
        return 0;
    }

    private function getPrice($value)
    {
        if ($value == null) {
            return 0;
        }
        return $value;
    }



}

