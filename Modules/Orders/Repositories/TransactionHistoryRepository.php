<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\TransactionHistory;
use Modules\User\Entities\Models\PharmacyBusiness;

class TransactionHistoryRepository
{
    public function getAllOrders()
    {
        return DB::table('orders')
            ->select(DB::raw('SUM(pharmacy_amount) as total_amount,pharmacy_id, pharmacy_businesses.pharmacy_name'))
            ->join('pharmacy_businesses', 'orders.pharmacy_id', '=', 'pharmacy_businesses.user_id')
            ->where('status', 3)
            ->groupBy('pharmacy_id')
            ->get();
    }

    public function getAllTransactionHistories($district_id, $thana_id, $area_id)
    {
        $data = PharmacyBusiness::query();

        if ($area_id !== null) {
            $data->where('area_id', $area_id);
        }
        if ($thana_id !== null && $area_id == null) {
            $data->whereHas('area', function ($query) use ($thana_id) {
                $query->where('thana_id', $thana_id);
            });
        }
        if ($district_id !== null && $thana_id == null && $area_id == null) {
            $data->whereHas('area.thana', function ($query) use ($district_id) {
                $query->where('district_id', $district_id);
            });
        }

        $data->with(['pharmacyTransaction' => function ($query) {
            $query->select(DB::raw('SUM(amount) as amount, pharmacy_id'))->groupBy('pharmacy_id');
        }]);

        $data->with(['pharmacyOrder' => function ($query) {
            $query->select('pharmacy_id',
                DB::raw('sum(case when payment_type = 1 then subidha_comission END) as `subidha_amount`'),
                DB::raw('sum(case when payment_type = 2 then pharmacy_amount END) as `pharmacy_amount`'))
                ->where('status', 3)
                ->groupBy('pharmacy_id');
        }]);

        return $data->paginate(config('subidha.item_per_page'));
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getEpayTransactionHistories($request)
    {
        $district_id = $request->district_id;
        $thana_id = $request->thana_id;
        $area_id = $request->area_id;

        $data = Order::query();
        if ($area_id !== null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area', function ($query) use ($area_id) {
                $query->where('area_id', $area_id);
            });
        }
        if ($thana_id !== null && $area_id == null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area.thana', function ($query) use ($thana_id) {
                $query->where('thana_id', $thana_id);
            });
        }
        if ($district_id !== null && $thana_id == null && $area_id == null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area.thana.district', function ($query) use ($district_id) {
                $query->where('district_id', $district_id);
            });
        }

        return $data->with('pharmacy.pharmacyBusiness')
            ->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount, SUM(subidha_comission) as subidha_comission, pharmacy_id'))
            ->where('status', 3)
            ->where('payment_type', 2)
            ->groupBy('pharmacy_id')
            ->get();

    }

    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCodTransactionHistories($request)
    {
        $data = Order::query();
        if ($request->area_id !== null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area', function ($query) use ($request) {
                $query->where('area_id', $request->area_id);
            });
        }
        if ($request->thana_id !== null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area.thana', function ($query) use ($request) {
                $query->where('thana_id', $request->thana_id);
            });
        }
        if ($request->district_id !== null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area.thana.district', function ($query) use ($request) {
                $query->where('district_id', $request->district_id);
            });
        }

        return $data->with('pharmacy.pharmacyBusiness')
            ->select(DB::raw('SUM(customer_amount) as customer_amount, SUM(pharmacy_amount) as pharmacy_amount, SUM(subidha_comission) as subidha_comission, pharmacy_id'))
            ->where('status', 3)
            ->where('payment_type', 1)
            ->groupBy('pharmacy_id')
            ->get();
    }

    public function getPayment($request, $id)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $data = TransactionHistory::query();
        $data->where('pharmacy_id', $id);

        if ($startDate != null || $endDate != null) {
            $data->whereBetween('date', [$startDate ?? Carbon::today()->subDays(30), $endDate ?? Carbon::today()]);
        }

        return $data->paginate(config('subidha.item_per_page'));
    }

    /**
     * @param $request
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCod($request, $id)
    {
        $data = Order::query();
        if ($request->start_date != null || $request->end_date != null) {
            $data->whereBetween('order_date', [$request->start_date ?? Carbon::today()->subDays(30), $request->end_date ?? Carbon::today()]);

        }
        return $data->where('pharmacy_id', $id)->where('payment_type', 1)->where('status', 3)->paginate(10);
    }


    public function getEpay($request, $id)
    {
        $data = Order::query();
        if ($request->start_date !== null || $request->end_date !== null) {
            $data->whereBetween('order_date', [$request->start_date ?? Carbon::today()->subDays(30), $request->end_date ?? Carbon::today()]);
        }

        return $data->where('pharmacy_id', $id)->where('payment_type', 2)->where('status', 3)->paginate(10);
    }

    public function store($request)
    {
        $data = new TransactionHistory();


        $data->pharmacy_id = $request->pharmacy_id;
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
            ->where('status', 3)
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        $pharmacy_epay_amount = DB::table('orders')
            ->select(DB::raw('SUM(pharmacy_amount) as total_amount,pharmacy_id'))
            ->where('status', 3)
            ->where('payment_type', 2)
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        $subidha_cod_amount = DB::table('orders')
            ->select(DB::raw('SUM(subidha_comission) as total_amount,pharmacy_id'))
            ->where('status', 3)
            ->where('payment_type', 1)
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        $pharmacyAmount = DB::table('orders')
            ->select(DB::raw('SUM(pharmacy_amount) as pharmacy_amount, pharmacy_id'))
            ->where('pharmacy_id', $pharmacy_id)
            ->where('status', 3)
            ->first();

        $transactionHistory = DB::table('transaction_history')
            ->select(DB::raw('SUM(amount) as amount, pharmacy_id'))
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        return [
            'order' => $order,
            'pharmacyAmount' => $pharmacyAmount,
            'due' => ($pharmacy_epay_amount->total_amount - $subidha_cod_amount->total_amount) - $transactionHistory->amount,
        ];
    }

    public function pharmacySalesHistory($pharmacy_id)
    {
        return Order::where('pharmacy_id', $pharmacy_id)->where('status', 3)->orderBy('id', 'desc')->paginate(20);
    }

    public function pharmacyTotalSale($pharmacy_id)
    {

        return Order::select('pharmacy_id',
            DB::raw('sum(case when payment_type = 1 then customer_amount END) as `cod_amount`'),
            DB::raw('sum(case when payment_type = 2 then pharmacy_amount END) as `epay_amount`'))
            ->where('pharmacy_id', $pharmacy_id)->where('status', 3)->first();
    }

    public function pharmacyOrders($pharmacy_id)
    {
        return Order::where('pharmacy_id', $pharmacy_id)->where('status', 3)->get();
    }


    public function TotalPendingOrders($pharmacy_id)
    {
        return Order::where('pharmacy_id', $pharmacy_id)->where('status', 0)->get();
    }

    public function completeOrdersByMonth($pharmacy_id)
    {
        return Order::select(DB::raw('sum(case when payment_type = 1 then customer_amount END) as `cod_amount`'),
            DB::raw('sum(case when payment_type = 2 then pharmacy_amount END) as `epay_amount`'),
            DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->where('status', 3)
            ->where('pharmacy_id', $pharmacy_id)
            ->get();
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
        $data = PharmacyBusiness::query();
        $data->with(['pharmacyTransaction' => function ($query) use ($id) {
            $query->select(DB::raw('SUM(amount) as amount, pharmacy_id'))->where('pharmacy_id', $id);
        }]);
        $data->with(['pharmacyOrder' => function ($query) use ($id) {
            $query->select('pharmacy_id',
                DB::raw('sum(case when payment_type = 1 then subidha_comission END) as `subidha_amount`'),
                DB::raw('sum(case when payment_type = 2 then pharmacy_amount END) as `pharmacy_amount`'))
                ->where('status', 3)
                ->where('pharmacy_id', $id);
        }]);

        return $data->where('user_id', $id)->first();
    }


}
