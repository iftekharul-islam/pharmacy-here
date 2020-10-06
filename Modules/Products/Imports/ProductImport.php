<?php


namespace Modules\Products\Imports;


use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Products\Entities\Model\Company;
use Modules\Products\Entities\Model\Generic;
use Modules\Products\Entities\Model\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{

    use Importable;

    public function collection(Collection $rows)
    {
//        dd($rows[0]);

        foreach ($rows as $row) {

            $genericId = $this->getGenericId($row['generic']);
//            $companyId = $this->getCompanyId($row['company']);
//            $formId = $this->getFormId($row['dosage_description']);


            $data['name']    = $row['brand']; // Brand in excel
//            $data['manufacturing_company_id'] = $companyId;
//            $data['generic_id']     = $genericId;
//            'form_id'     => $formId, // Dosage description in excel
//            'strength'     => $row['strength'],
//            'purchase_price'    => $row['priceunit'],
//            'is_saleable'    => true,
//            'is_prescripted'    => false,
//            'is_pre_order'    => false,
//            'min_order_qty'    => 0,

//            Product::create($data);
        }

    }

    private function getGenericId($name)
    {
//        dd($generic);
//        $data = Generic::firstOrCreate(['name' => $generic]);
        $data = Generic::where('name', $name)->first();

//        dd($data);
        if ($data == null) {
            $newData = Generic::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
            logger('New Data');
            logger($newData);
            dd($newData);
            return $newData->id;
        }
//        dd($data);
    }

/*
    private function getFormId($name)
    {
        $data = Form::where('name', $name)->first();

        if ($data == null) {
            $newData = Form::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
            dd($newData);
            return $newData->id;
        }
        dd($data);
    }

    private function getCompanyId($name)
    {
        $data = Company::where('name', $name)->first();

        if ($data == null) {
            $newData = Company::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'status' => true,
            ]);
            dd($newData);
            return $newData->id;
        }
        dd($data);
    }
*/



}
