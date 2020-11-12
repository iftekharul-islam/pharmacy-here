<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\TransactionHistory;

class CodTransactionHistoryByIdExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
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

        $transaction =  Order::query();

        $allTransactionHistories = $this->query($transaction);

        $transactionCollection = new Collection();
        foreach ($allTransactionHistories as $allTransaction) {
            $transactionCollection->push((object) [
                'order_date' => $allTransaction->order_date,
                'customer_amount' => $allTransaction->customer_amount,
                'pharmacy_amount' => $allTransaction->pharmacy_amount,
                'subidha_comission'=> $allTransaction->subidha_comission,
            ]);
        }
        return $transactionCollection;
    }

    public function query($transaction)
    {
        if ($this->toDate !== null || $this->endDate !== null) {
            return $transaction->whereBetween('order_date', [$this->endDate, $this->toDate])->where('pharmacy_id', $this->userId)->get();
        }
        return $transaction->where('pharmacy_id', $this->userId)->get();

    }

    public function map($transactionCollection): array
    {
        return [
            $transactionCollection->order_date ? $transactionCollection->order_date : '',
            $transactionCollection->customer_amount ? $transactionCollection->customer_amount : '',
            $transactionCollection->pharmacy_amount ? $transactionCollection->pharmacy_amount : '',
            $transactionCollection->subidha_comission ? $transactionCollection->subidha_comission : '',
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
        ];
    }
}
