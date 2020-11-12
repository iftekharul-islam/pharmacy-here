<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Orders\Entities\Models\Order;

class CodTransactionExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    use Exportable;
    protected $district, $thana, $area;

    public function __construct($district, $thana, $area)
    {
        $this->district = $district;
        $this->thana = $thana;
        $this->area = $area;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $transaction = Order::query();
        $allTransactionHistories = $this->dataQuery($transaction);
        $transactionCollection = new Collection();

        foreach ($allTransactionHistories as $allTransaction) {
            $transactionCollection->push((object)[
                'pharmacy_name' => $allTransaction->pharmacy->pharmacyBusiness->pharmacy_name,
                'customer_amount' => $allTransaction->customer_amount,
                'pharmacy_amount' => $allTransaction->pharmacy_amount,
                'subidha_comission' => $allTransaction->subidha_comission,
            ]);
        }

        return $transactionCollection;
    }

    public function dataQuery($transaction)
    {

        if ($this->area !== null) {
            return $transaction->with('pharmacy.pharmacyBusiness')
                ->whereHas('pharmacy.pharmacyBusiness.area', function ($query) {
                    $query->where('area_id', $this->area);
                })
                ->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount, SUM(subidha_comission) as subidha_comission, pharmacy_id'))
                ->where('status', 3)
                ->where('payment_type', 1)
                ->groupBy('pharmacy_id')
                ->get();
        }
        if ($this->thana !== null) {
            return $transaction->with('pharmacy.pharmacyBusiness')
                ->whereHas('pharmacy.pharmacyBusiness.area.thana', function ($query) {
                    $query->where('thana_id', $this->thana);
                })
                ->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount, SUM(subidha_comission) as subidha_comission, pharmacy_id'))
                ->where('status', 3)
                ->where('payment_type', 1)
                ->groupBy('pharmacy_id')
                ->get();
        }
        if ($this->district !== null) {
            return $transaction->with('pharmacy.pharmacyBusiness')
                ->whereHas('pharmacy.pharmacyBusiness.area.thana.district', function ($query) {
                    $query->where('district_id', $this->district);
                })
                ->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount, SUM(subidha_comission) as subidha_comission, pharmacy_id'))
                ->where('status', 3)
                ->where('payment_type', 1)
                ->groupBy('pharmacy_id')
                ->get();
        }

        return $transaction->with('pharmacy.pharmacyBusiness')
            ->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount, SUM(subidha_comission) as subidha_comission, pharmacy_id'))
            ->where('status', 3)
            ->where('payment_type', 1)
            ->groupBy('pharmacy_id')
            ->get();
    }

    public function map($transactionCollection): array
    {
        return [
            $transactionCollection->pharmacy_name ? $transactionCollection->pharmacy_name : '',
            $transactionCollection->customer_amount ? $transactionCollection->customer_amount : '',
            $transactionCollection->pharmacy_amount ? $transactionCollection->pharmacy_amount : '',
            $transactionCollection->subidha_comission ? $transactionCollection->subidha_comission : '',
        ];
    }

    public function headings(): array
    {
        return [
            'Pharmacy Name',
            'Order Amount',
            'Pharmacy Amount',
            'Subidha Comission',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 20,
            'D' => 20,
        ];
    }
}
