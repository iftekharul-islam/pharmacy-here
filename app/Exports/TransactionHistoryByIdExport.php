<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Orders\Entities\Models\TransactionHistory;

class TransactionHistoryByIdExport implements FromCollection, WithHeadings, WithMapping
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
        $transaction =  TransactionHistory::query();

        $allTransactionHistories = $this->query($transaction);

        $transactionCollection = new Collection();
        foreach ($allTransactionHistories as $allTransaction) {
            $transactionCollection->push((object) [
                'pharmacy_name' => $allTransaction->pharmacy->pharmacy_name,
                'date' => $allTransaction->date,
                'transaction_id' => $allTransaction->transaction_id,
                'bank_name' => $allTransaction->bank_name,
                'amount'=> $allTransaction->amount,
            ]);
        }
        return $transactionCollection;
    }
    public function query($transaction)
    {
        if ($this->toDate !== null || $this->endDate !== null) {
            return $transaction->with('pharmacy')->whereBetween('date', [$this->toDate, $this->endDate])->where('pharmacy_id', $this->userId)->get();
        }
        return $transaction->with('pharmacy')->where('pharmacy_id', $this->userId)->get();

    }

    public function map($transactionCollection): array
    {
        return [
                $transactionCollection->date ? $transactionCollection->date : '',
                $transactionCollection->transaction_id ? $transactionCollection->transaction_id : '',
                $transactionCollection->bank_name ? $transactionCollection->bank_name : '',
                $transactionCollection->amount ? $transactionCollection->amount : '',
        ];
    }


    public function headings(): array
    {
        return [
                'Date',
                'Transaction ID',
                'Payment Through',
                'Amount',
            ];
    }
}
