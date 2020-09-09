<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\TransactionHistory;

class TransactionHistoryRepository
{
    public function all()
    {
        return TransactionHistory::with('pharmacy.pharmacyBusiness')
            ->selectRaw(DB::raw( '(SELECT SUM(amount) - SUM(subidha_comission) FROM orders WHERE status=9 GROUP BY pharmacy_id) as total_amount'))
            ->groupBy('pharmacy_id')
            ->selectRaw('id,SUM(amount) as amount, pharmacy_id')
            ->paginate(10);
    }

    public function get($id)
    {
        return TransactionHistory::with('pharmacy.pharmacyBusiness')
            ->where('pharmacy_id', $id)
            ->paginate(10);
    }

    public function store($request)
    {
        $data = new TransactionHistory();


        $data->pharmacy_id = $request->pharmacy_id;
//        $data->transaction_id = 112233;
        $data->date = Carbon::now()->format('Y-m-d');

        if (isset($request->transaction_id)) {
            $data->transaction_id = $request->transaction_id;
        }
        if (isset($request->amount)) {
            $data->amount = $request->amount;
        }
        if (isset($request->payment_method)) {
            $data->payment_method = $request->payment_method;
        }

//        if (isset($request->bank_account_name)) {
//            $data->bank_account_name = $request->bank_account_name;
//        }
//        if (isset($request->bank_account_number)) {
//            $data->bank_account_number = $request->bank_account_number;
//        }
//        if (isset($request->bank_name)) {
//            $data->bank_name = $request->bank_name;
//        }
//        if (isset($request->bank_branch_name)) {
//            $data->bank_branch_name = $request->bank_branch_name;
//        }

        $data->save();

        return $data;
    }

    public function getPharmacyTransaction($pharmacy_id)
    {
        return TransactionHistory::where('pharmacy_id', $pharmacy_id)->paginate(10);
    }

    public function pharmacyTotalSale($pharmacy_id)
    {
        return Order::where('pharmacy_id', $pharmacy_id)->where('status', 3)->orderBy('id','desc')->paginate(5);
    }

    public function storePharmacyTransaction($request, $pharmacy_id)
    {
        $data = new TransactionHistory();

        $data->pharmacy_id = $pharmacy_id;
        $data->transaction_id = 112233;

        $data->date = Carbon::now()->format('Y-m-d');

        if (isset($request->amount)) {
            $data->amount = $request->amount;
        }
        if (isset($request->payment_method)) {
            $data->payment_method = $request->payment_method;
        }
        if (isset($request->bank_account_name)) {
            $data->bank_account_name = $request->bank_account_name;
        }
        if (isset($request->bank_account_number)) {
            $data->bank_account_number = $request->bank_account_number;
        }
        if (isset($request->bank_name)) {
            $data->bank_name = $request->bank_name;
        }
        if (isset($request->bank_branch_name)) {
            $data->bank_branch_name = $request->bank_branch_name;
        }

        $data->save();

        return $data;


    }

    public function getPharmacyInfo($id)
    {
        return TransactionHistory::with('pharmacy.pharmacyBusiness')
            ->selectRaw(DB::raw( '(SELECT SUM(amount) - SUM(subidha_comission) FROM orders WHERE status=9 GROUP BY pharmacy_id) as total_amount'))
            ->selectRaw('id,(SELECT SUM(amount) FROM transaction_history GROUP BY pharmacy_id) as amount, pharmacy_id')
            ->where('id',$id)->first();
    }


}
