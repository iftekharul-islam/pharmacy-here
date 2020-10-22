<?php


namespace Modules\Alarm\Repositories;


use Modules\Alarm\Entities\Models\Reminder;

class ReminderRepository
{
    public function all($customer_id)
    {
        return Reminder::where('customer_id', $customer_id)->get();
    }

    public function create($request, $customer_id)
    {
        $data = new Reminder();

        if ($request->has('reminder_id') && $request->get('reminder_id')) {
            $data->reminder_id = $request->reminder_id;
        }

        if ($request->has('frequency') && $request->get('frequency')) {
            $item = $request->frequency;
            $data->frequency = json_encode( $item );
        }

        if ($request->has('start_date') && $request->get('start_date')) {
            $data->start_date = $request->start_date;
        }

        if ($request->has('duration_type') && $request->get('duration_type')) {
            $data->duration_type = $request->duration_type;
        }

        if ($request->has('duration_days') && $request->get('duration_days')) {
            $data->duration_days = $request->duration_days;
        }

        if ($request->has('days_type') && $request->get('days_type')) {
            $data->days_type = $request->days_type;
        }

        if ($request->has('specific_days') && $request->get('specific_days')) {
            $data->specific_days = $request->specific_days;
        }

        if ($request->has('medicine_type') && $request->get('medicine_type')) {
            $data->medicine_type = $request->medicine_type;
        }

        if ($request->has('medicine_strength') && $request->get('medicine_strength')) {
            $data->medicine_strength = $request->medicine_strength;
        }

        if ($request->has('medicine_name') && $request->get('medicine_name')) {
            $data->medicine_name = $request->medicine_name;
        }

        if ($request->has('patient_name') && $request->get('patient_name')) {
            $data->patient_name = $request->patient_name;
        }

        $data->customer_id = $customer_id;
        $data->save();

        return $data;

    }

    public function update($request, $reminder_id, $customer_id)
    {
        $data = Reminder::where('reminder_id', $reminder_id)->where('customer_id', $customer_id)->first();

        if ($request->has('frequency') && $request->get('frequency')) {
            $item = $request->frequency;
            $data->frequency = json_encode( $item );
        }

        if ($request->has('start_date') && $request->get('start_date')) {
            $data->start_date = $request->start_date;
        }

        if ($request->has('duration_type') && $request->get('duration_type')) {
            $data->duration_type = $request->duration_type;
        }

        if ($request->has('duration_days') && $request->get('duration_days')) {
            $data->duration_days = $request->duration_days;
        }

        if ($request->has('days_type') && $request->get('days_type')) {
            $data->days_type = $request->days_type;
        }

        if ($request->has('specific_days') && $request->get('specific_days')) {
            $data->specific_days = $request->specific_days;
        }

        if ($request->has('medicine_type') && $request->get('medicine_type')) {
            $data->medicine_type = $request->medicine_type;
        }

        if ($request->has('medicine_strength') && $request->get('medicine_strength')) {
            $data->medicine_strength = $request->medicine_strength;
        }

        if ($request->has('medicine_name') && $request->get('medicine_name')) {
            $data->medicine_name = $request->medicine_name;
        }

        if ($request->has('patient_name') && $request->get('patient_name')) {
            $data->patient_name = $request->patient_name;
        }

        $data->save();

        return $data;
    }

    public function delete($reminder_id, $customer_id)
    {
        $data = Reminder::where('reminder_id', $reminder_id)->where('customer_id', $customer_id)->first();

        return $data->delete();
    }

}
