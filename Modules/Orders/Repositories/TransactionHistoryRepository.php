<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\TransactionHistory;

class TransactionHistoryRepository
{
    public function all()
    {
//        return TransactionHistory::with('pharmacy.pharmacyBusiness')
//            ->groupBy('pharmacy_id')
//            ->get();

//        $phar
    }

    public function getAllOrders()
    {
        return DB::table('orders')
            ->select(DB::raw('SUM(pharmacy_amount) as total_amount,pharmacy_id, pharmacy_businesses.pharmacy_name'))
            ->join('pharmacy_businesses', 'orders.pharmacy_id', '=', 'pharmacy_businesses.user_id')
            ->where('status',3)
            ->groupBy('pharmacy_id')
            ->get();
    }

    public function getAllTransactionHistories($request)
    {
        if ($request->area_id !== null) {
            return TransactionHistory::with(['pharmacy' => function ($query) {
                $query->select('user_id', 'pharmacy_name');
            },
                'pharmacy.pharmacyOrder' =>  function ($query) {
                    $query->select(DB::raw('SUM(amount) as amount, pharmacy_id'))->where('status', 3)->groupBy('pharmacy_id')->get();
                }])->whereHas('pharmacy.area', function ($query) use ($request) {
                $query->where('area_id', $request->area_id);
            })
                ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
                ->groupBy('pharmacy_id')
                ->get();
        }

        return TransactionHistory::with(['pharmacy' => function ($query) {
            $query->select('user_id', 'pharmacy_name');
        },
            'pharmacy.pharmacyOrder' =>  function ($query) {
                $query->select(DB::raw('SUM(amount) as amount, pharmacy_id'))->where('status', 3)->groupBy('pharmacy_id')->get();
            }])
            ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
            ->groupBy('pharmacy_id')
            ->get();
    }

    public function get($request, $id)
    {
        $startDate = $request->start_date ? $request->start_date : Carbon::today()->subDays(30);
        $endDate = $request->end_date ? $request->end_date : Carbon::today();

        if ($startDate !== null || $endDate !== null) {
            $TransactionHistories = TransactionHistory::whereBetween('date', [$startDate, $endDate])->where('pharmacy_id', $id)->paginate(10);
            return $TransactionHistories;
        }

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

    public function getPharmacyTransactionAmount($pharmacy_id)
    {
        $order = DB::table('orders')
            ->select(DB::raw('SUM(pharmacy_amount) as total_amount,pharmacy_id'))
            ->where('status',3)
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        $pharmacy_epay_amount = DB::table('orders')
            ->select(DB::raw('SUM(pharmacy_amount) as total_amount,pharmacy_id'))
            ->where('status',3)
            ->where('payment_type',2)
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        $subidha_cod_amount = DB::table('orders')
            ->select(DB::raw('SUM(subidha_comission) as total_amount,pharmacy_id'))
            ->where('status',3)
            ->where('payment_type',1)
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        $transactionHistory = DB::table('transaction_history')
            ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        return [
            'order' => $order,
            'transactionHistory' => $transactionHistory,
            'due' => ($pharmacy_epay_amount->total_amount - $subidha_cod_amount->total_amount) - $transactionHistory->amount,
        ];
    }

    public function pharmacySalesHistory($pharmacy_id)
    {
        return Order::where('pharmacy_id', $pharmacy_id)->where('status', 3)->orderBy('id','desc')->paginate(20);
    }

    public function pharmacyTotalSale($pharmacy_id)
    {
//        return Order::where('pharmacy_id', $pharmacy_id)->where('status', 3)->orderBy('id','desc')->paginate(5);
        return Order::where('pharmacy_id', $pharmacy_id)->where('status', 3)->get();
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
        return TransactionHistory::with([
            'pharmacy.pharmacyOrder' =>  function ($query) use ($id) {
                $query->select(DB::raw('SUM(amount) as amount, pharmacy_id'))->where('status', 3)->where('pharmacy_id', $id)
                    ->first();
            }])
            ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
            ->where('pharmacy_id', $id)
            ->first();
    }


}
