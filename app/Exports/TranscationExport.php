<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Orders\Entities\Models\TransactionHistory;

class TranscationExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    use Exportable;
    protected $district, $thana, $area;

    public function __construct($district, $thana, $area)
    {
        $this->district = $district;
        $this->thana = $thana;
        $this->area = $area;
    }

    public function collection()
    {
        $transaction = TransactionHistory::query();
        $allTransactionHistories = $this->query($transaction);

        $transactionCollection = new Collection();
        foreach ($allTransactionHistories as $allTransaction) {
            $transactionCollection->push((object)[
                'pharmacy_name' => $allTransaction->pharmacy->pharmacy_name,
                'customer_amount' => $allTransaction->pharmacy->pharmacyOrder[0]->customer_amount,
                'pharmacy_amount' => $allTransaction->pharmacy->pharmacyOrder[0]->pharmacy_amount,
                'amount' => $allTransaction->amount,
            ]);
        }
        return $transactionCollection;
    }

    public function query($transaction)
    {
        if ($this->district !== null) {
            $allTransactionHistories = $transaction->with(['pharmacy' => function ($query) {
                $query->select('user_id', 'pharmacy_name');
            },
                'pharmacy.pharmacyOrder' => function ($query) {
                    $query->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount,  pharmacy_id'))->where('status', 3)->where('payment_type', 2)->groupBy('pharmacy_id')->get();
                }])->whereHas('pharmacy.area', function ($query) {
                $query->where('area_id', $this->district);
            })
                ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
                ->groupBy('pharmacy_id')
                ->get();
        } elseif ($this->thana !== null) {
            $allTransactionHistories = $transaction->with(['pharmacy' => function ($query) {
                $query->select('user_id', 'pharmacy_name');
            },
                'pharmacy.pharmacyOrder' => function ($query) {
                    $query->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount,  pharmacy_id'))->where('status', 3)->where('payment_type', 2)->groupBy('pharmacy_id')->get();
                }])->whereHas('pharmacy.area.thana', function ($query) {
                $query->where('thana_id', $this->thana);
            })
                ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
                ->groupBy('pharmacy_id')
                ->get();
        } elseif ($this->area !== null) {
            $allTransactionHistories = $transaction->with(['pharmacy' => function ($query) {
                $query->select('user_id', 'pharmacy_name');
            },
                'pharmacy.pharmacyOrder' => function ($query) {
                    $query->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount,  pharmacy_id'))->where('status', 3)->where('payment_type', 2)->groupBy('pharmacy_id')->get();
                }])->whereHas('pharmacy.area.thana.district', function ($query) {
                $query->where('district_id', $this->area);
            })
                ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
                ->groupBy('pharmacy_id')
                ->get();
        } else {
            $allTransactionHistories = $transaction->with(['pharmacy' => function ($query) {
                $query->select('user_id', 'pharmacy_name');
            },
                'pharmacy.pharmacyOrder' => function ($query) {
                    $query->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount, pharmacy_id'))->where('status', 3)->where('payment_type', 2)->groupBy('pharmacy_id')->get();
                }])
                ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
                ->groupBy('pharmacy_id')
                ->get(['pharmacy_name', 'customer_amount', 'pharmacy_amount', 'amount']);
        }

        return $allTransactionHistories;
    }

    public function map($transactionCollection): array
    {
        return [
            $transactionCollection->pharmacy_name ? $transactionCollection->pharmacy_name : '',
            $transactionCollection->customer_amount ? $transactionCollection->customer_amount : '',
            $transactionCollection->pharmacy_amount ? $transactionCollection->pharmacy_amount : '',
            $transactionCollection->amount ? $transactionCollection->amount : '',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Pharmacy Name',
            'Order Amount',
            'Pharmacy Amount',
            'Paid Amount',
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
            'D' => 20,
        ];
    }
}
