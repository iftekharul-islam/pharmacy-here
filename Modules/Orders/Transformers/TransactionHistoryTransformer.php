<?php


namespace Modules\Orders\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Address\Transformers\AddressTransformer;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\TransactionHistory;
use Modules\Prescription\Transformers\PrescriptionTransformer;
use SebastianBergmann\Environment\Console;

class TransactionHistoryTransformer extends TransformerAbstract
{


    public function transform(TransactionHistory $item)
    {
        return [
            'id'                        => $item->id,
            "date"                      => Carbon::parse($item->date)->format('d-m-Y'),
            "transaction_id"            => $item->transaction_id,
            "amount"                    => $item->amount,
            "payment_method"            => $item->payment_method
        ];
    }

}
