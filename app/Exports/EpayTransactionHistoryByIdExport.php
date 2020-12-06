<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Orders\Entities\Models\Order;

class EpayTransactionHistoryByIdExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    use Exportable;
    protected $endDate, $toDate, $userId;

    public function __construct($endDate, $toDate, $userId)
    {
        $this->endDate = $endDate;
        $this->toDate = $toDate;
        $this->userId = $userId;
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
                'order_date' => $allTransaction->order_date,
                'customer_amount' => $allTransaction->customer_amount,
                'pharmacy_amount' => $allTransaction->pharmacy_amount,
                'subidha_comission' => $allTransaction->subidha_comission,
                'point_amount' => $allTransaction->point_amount
            ]);
        }
        return $transactionCollection;
    }

    public function dataQuery($transaction)
    {
        if ($this->toDate !== null || $this->endDate !== null) {
            return $transaction->whereBetween('order_date', [$this->toDate, $this->endDate])
                ->where('payment_type', 2)
                ->where('status', 3)
                ->where('pharmacy_id', $this->userId)->get();
        }
        return $transaction->where('pharmacy_id', $this->userId)->where('payment_type', 2)->where('status', 3)->get();

    }

    public function map($transactionCollection): array
    {
        return [
            $transactionCollection->order_date ?? '',
            $transactionCollection->customer_amount ?? '',
            $transactionCollection->pharmacy_amount ?? '',
            $transactionCollection->subidha_comission ??'',
            $transactionCollection->point_amount ?? '',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Order Date',
            'Customer Amount',
            'Pharmacy Amount',
            'Subidha Amount',
            'Point Amount'
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 15,
        ];
    }
}
