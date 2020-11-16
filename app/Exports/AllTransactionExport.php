<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Orders\Repositories\TransactionHistoryRepository;
use Modules\User\Entities\Models\PharmacyBusiness;

class AllTransactionExport implements FromCollection, WithHeadings, WithColumnWidths
{
    use Exportable;
    protected $district, $thana, $area;

    /**
     * AllTransactionExport constructor.
     * @param TransactionHistoryRepository $repository
     * @param $district
     * @param $thana
     * @param $area
     */
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
        $transaction = PharmacyBusiness::query();
        $allTransactionHistories = $this->dataQuery($transaction);
        logger($allTransactionHistories);

        $transactionCollection = new Collection();
        foreach ($allTransactionHistories as $allTransaction) {
            $pharmacy_amount = $allTransaction->pharmacyOrder[0]->pharmacy_amount ?? 0;
            $subidha_amount = $allTransaction->pharmacyOrder[0]->subidha_amount ?? 0;
            $amount = $allTransaction->pharmacyTransaction[0]->amount ?? 0;
            $payable = $subidha_amount + $amount;

            if (!empty($pharmacy_amount)) {
                $transactionCollection->push((object)[
                    'pharmacy_name' => $allTransaction->pharmacy_name,
                    'pharmacy_amount' => $pharmacy_amount,
                    'subidha_amount' => $subidha_amount,
                    'paid' => $amount,
                    'payable_amount' => $payable - $pharmacy_amount,
                ]);
            }
        }
        return $transactionCollection;
    }

    public function dataQuery($transaction)
    {
        if ($this->area !== null) {
            $transaction->where('area_id', $this->area);
        }
        if ($this->thana !== null && $this->area == null) {
            $transaction->whereHas('area', function ($query) {
                $query->where('thana_id', $this->thana);
            });
        }
        if ($this->district !== null && $this->thana == null && $this->area == null) {
            $transaction->whereHas('area.thana', function ($query) {
                $query->where('district_id', $this->district);
            });
        }

        $transaction->with(['pharmacyTransaction' => function ($query) {
            $query->select(DB::raw('SUM(amount) as amount, pharmacy_id'))->groupBy('pharmacy_id');
        }]);

        $transaction->with(['pharmacyOrder' => function ($query) {
            $query->select('pharmacy_id',
                DB::raw('sum(case when payment_type = 1 then subidha_comission END) as `subidha_amount`'),
                DB::raw('sum(case when payment_type = 2 then pharmacy_amount END) as `pharmacy_amount`'))
                ->where('status', 3)
                ->groupBy('pharmacy_id');
        }]);

        return $transaction->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Pharmacy Name',
            'Pharmacy Amount',
            'Subidha Amount',
            'Paid',
            'Payable'
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 20,
            'D' => 10,
            'E' => 15,
        ];
    }
}
