<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Modules\User\Entities\Models\User;

class PharmacyExport implements FromCollection, WithHeadings, WithColumnWidths
{
    use Exportable;
    protected $district, $thana, $area, $search;

    public function __construct($district, $thana, $area, $search)
    {
        $this->district = $district;
        $this->thana = $thana;
        $this->area = $area;
        $this->search = $search;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $pharmacy = User::query();

        $pharmacyList = $this->dataQuery($pharmacy);

        $pharmacyCollection = new Collection();

        foreach ($pharmacyList as $pharmacy) {
            $pharmacyCollection->push((object)[
                'owner_name' => $pharmacy->name,
                'pharmacy_name' => $pharmacy->pharmacyBusiness->pharmacy_name ?? 'N/A',
                'address' => $pharmacy->pharmacyBusiness ? $pharmacy->pharmacyBusiness->pharmacy_address
                    . ',' . $pharmacy->pharmacyBusiness->area->name . ',' . $pharmacy->pharmacyBusiness->area->thana->name
                    . ',' . $pharmacy->pharmacyBusiness->area->thana->district->name : 'N/A',
                'phone_number' => $pharmacy->phone_number,
                'email' => $pharmacy->email,
                'status' => $pharmacy->status == 1 ? 'Active' : 'Inactive',
                'created_at' => $pharmacy->pharmacyBusiness->created_at ? Carbon::parse($pharmacy->pharmacyBusiness->created_at)->format('d-m-Y') : 'N/A'
            ]);
        }
        logger($pharmacyCollection);
        return $pharmacyCollection;
    }

    public function dataQuery($pharmacy)
    {
        $pharmacy->with('pharmacyBusiness', 'pharmacyBusiness.area', 'pharmacyBusiness.area.thana', 'pharmacyBusiness.area.thana.district', 'weekends')
            ->where('is_pharmacy', 1)
            ->orderby('id', 'desc');

        if ($this->search !== null) {
            $pharmacy->whereHas('pharmacyBusiness', function ($query) {
                $query->where('pharmacy_name', 'LIKE', "%{$this->search}%");
            });
        }
        if ($this->area !== null) {
            $pharmacy->whereHas('pharmacyBusiness', function ($query) {
                $query->where('area_id', $this->area);
            });
        }
        if ($this->thana !== null && $this->area == null) {
            $pharmacy->whereHas('pharmacyBusiness.area', function ($query) {
                $query->where('thana_id', $this->thana);
            });
        }
        if ($this->district !== null && $this->thana == null && $this->area == null) {
            $pharmacy->whereHas('pharmacyBusiness.area.thana', function ($query) {
                $query->where('district_id', $this->district);
            });
        }

        return $pharmacy->get();

    }
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Pharmacy Owner',
            'Pharmacy Name',
            'Address',
            'Phone Number',
            'Email',
            'Status',
            'Create Date'
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 40,
            'D' => 15,
            'E' => 20,
            'F' => 10,
            'G' => 15,
        ];
    }
}
