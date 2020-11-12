<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Orders\Entities\Models\Order;

class OrderExport implements FromCollection, WithHeadings, WithColumnWidths
{
    use Exportable;
    protected $district, $thana, $area, $toDate, $endDate, $status;

    public function __construct($district, $thana, $area, $toDate, $endDate, $status)
    {
        $this->district = $district;
        $this->thana = $thana;
        $this->area = $area;
        $this->toDate = $toDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Order::query();
        $allOrders = $this->dataQuery($data);
        $orderCollection = new Collection();

        foreach ($allOrders as $order) {
            $orderCollection->push((object)[
                'order_no' => $order->order_no,
                'pharmacy_name' => $order->pharmacy->pharmacyBusiness->pharmacy_name,
                'date' => $order->order_date,
                'amount' => $order->pharmacy_amount,
            ]);
        }

        return $orderCollection;

    }

    /**
     * @param $data
     * @return mixed
     */
    public function dataQuery($data)
    {
        $data->with(['pharmacy.pharmacyBusiness'])->orderBy('id', 'desc');

        if ($this->area !== null) {
            $data->whereHas('pharmacy.pharmacyBusiness', function ($query) {
                $query->where('area_id', $this->area);
            });
        }
        if ($this->thana !== null && $this->area == null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area', function ($query) {
                $query->where('thana_id', $this->thana);
            });
        }
        if ($this->district !== null && $this->thana == null && $this->area == null) {
            $data->whereHas('pharmacy.pharmacyBusiness.area.thana', function ($query) {
                $query->where('district_id', $this->district);
            });
        }
        if ($this->status !== null) {
            $data->where('status', $this->status);
        }
        if ($this->toDate !== null || $this->endDate !== null) {
            $data->whereBetween('order_date', [$this->toDate ?? Carbon::today()->subDays(30), $this->endDate ?? Carbon::today()]);
        }

        return $data->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Order Number',
            'Pharmacy Name',
            'Amount',
            'Date',
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 25,
            'C' => 15,
            'D' => 10,
        ];
    }
}
