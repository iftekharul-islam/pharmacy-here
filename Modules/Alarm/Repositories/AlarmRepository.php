<?php


namespace Modules\Alarm\Repositories;


use Modules\Alarm\Entities\Models\Alarm;

class AlarmRepository
{
    public function all($customer_id)
    {
        return Alarm::where('customer_id', $customer_id)->get();
    }

    public function create($request, $customer_id)
    {
        $data = new Alarm();

        if ($request->has('alarm_id') && $request->get('alarm_id')) {
            $data->alarm_id = $request->alarm_id;
        }

        if ($request->has('date') && $request->get('date')) {
            $data->date = $request->date;
        }

        if ($request->has('reminder_id') && $request->get('reminder_id')) {
            $data->reminder_id = $request->reminder_id;
        }

        if ($request->has('status') && $request->get('status')) {
            $data->status = $request->status;
        }

        $data->customer_id = $customer_id;
        $data->save();

        return $data;
    }

    public function update($request, $alarm_id, $customer_id)
    {
        $data = Alarm::where('alarm_id', $alarm_id)->where('customer_id', $customer_id)->first();

        if ($request->has('date') && $request->get('date')) {
            $data->date = $request->date;
        }

        if ($request->has('reminder_id') && $request->get('reminder_id')) {
            $data->reminder_id = $request->reminder_id;
        }

        if ($request->has('status') && $request->get('status')) {
            $data->status = $request->status;
        }

        $data->save();

        return $data;
    }

    public function delete($alarm_id, $customer_id)
    {
        $data = Alarm::where('alarm_id', $alarm_id)->where('customer_id', $customer_id)->first();

        return $data->delete();
    }
}
