<?php


namespace Modules\Delivery\Repositories;


use Carbon\Carbon;
use Modules\Delivery\Entities\Models\DeliveryTime;

class DeliveryTimeRepository
{
    public function timeList($delivery_method)
    {
        return DeliveryTime::where('delivery_method', $delivery_method)->get();
    }

    public function create($request)
    {
        $data = $request->only('start_month', 'end_month', 'start_time', 'end_time', 'delivery_method');

        return DeliveryTime::create($data);
    }

    public function get($id)
    {
        return DeliveryTime::find($id);
    }

    public function update($request, $id)
    {
        $item = DeliveryTime::find($id);

        if ($request->has('start_month')) {
            $item->start_month = $request->start_month;
        }
        if ($request->has('end_month')) {
            $item->end_month = $request->end_month;
        }
        if ($request->has('start_time')) {
            $item->start_time = $request->start_time;
        }
        if ($request->has('end_time')) {
            $item->end_time = $request->end_time;
        }
        if ($request->has('delivery_method')) {
            $item->delivery_method = $request->delivery_method;
        }

        $item->save();

        return $item;
    }

    public function delete($id)
    {
        $item = DeliveryTime::find($id);

        return $item->delete();
    }

    public function getTimeList($month, $delivery_method)
    {
        $data = DeliveryTime::where('delivery_method', $delivery_method)->orderBy('start_time', 'asc')->get();

        $final_data = [
            'summer' => [
                "time" => [],
                "month" => []
            ],
            'winter' => [
                "time" => [],
                "month" => []
            ]
        ];

        foreach ($data as $item) {
            if ($item->start_month > $item->end_month) {
                $final_data['summer']['time'][] = [
                    'start_time' => Carbon::createFromFormat('H:i:s', $item->start_time)->format('h:i A'),
                    'end_time' => Carbon::createFromFormat('H:i:s', $item->end_time)->format('h:i A'),
                ];

                for ($i = $item->start_month; $i <= 12; $i++ ) {
                    if (!in_array($i, $final_data['summer']['month'])) {
                        $final_data['summer']['month'][] = $i;
                    }
                }
                for ($i = 1; $i <= $item->end_month; $i++ ) {
                    if (!in_array($i, $final_data['summer']['month'])) {
                        $final_data['summer']['month'][] = $i;
                    }
                }
            } else {
                $final_data['winter']['time'][] = [
                    'start_time' => Carbon::createFromFormat('H:i:s', $item->start_time)->format('h:i A'),
                    'end_time' => Carbon::createFromFormat('H:i:s', $item->end_time)->format('h:i A'),
                ];

                for ($i = $item->start_month; $i <= $item->end_month; $i++ ) {
                    if (!in_array($i, $final_data['winter']['month'])) {
                        $final_data['winter']['month'][] = $i;
                    }
                }
            }
        }

        if (in_array($month, $final_data['summer']['month'])) {
            return $final_data['summer']['time'];
        }
        return $final_data['winter']['time'];
    }
}
