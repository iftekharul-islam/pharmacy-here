<?php


namespace Modules\Notice\Repositories;


use Modules\Notice\Entities\Models\Notice;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;

class NoticeRepository
{
    public function all()
    {
        return Notice::orderby('id', 'desc')->paginate(20);
    }

    public function get($id)
    {
        return Notice::find($id);
    }

    public function create($request) {

        $data = new Notice();

        if (isset($request->notice)) {
            $data->notice = $request->notice;
        }
        if (isset($request->bn_notice)) {
            $data->bn_notice = $request->bn_notice;
        }
        if (isset($request->status)) {
            $data->status = $request->status;
        }
        if (isset($request->type)) {
            $data->type = $request->type;
        }

        $data->save();

        if ($request->sendNow) {

            if ($request->type == 1) {
                $users = User::whereHas('roles' , function($q){
                    $q->where('name', 'pharmacy');
                })->get()->pluck('id');
            }
            else {
                $users = User::whereHas('roles' , function($q){
                    $q->where('name', 'customer');
                })->get()->pluck('id');
            }

            foreach ($users as $user_id) {

                $deviceIds = UserDeviceId::where('user_id', $user_id)->get();
                $title = 'New Notice';
                logger('Sending Push Notification');
                foreach ($deviceIds as $deviceId) {
                    sendPushNotification($deviceId->device_id, $title, $request->notice, $id = "");
                }
            }

        }

        return $data;
    }

    public function delete($id)
    {
        $data = Notice::find($id);

        return $data->delete();
    }

    public function update($request, $id)
    {
        $data = Notice::find($id);

        if (isset($request->notice)) {
            $data->notice = $request->notice;
        }
        if (isset($request->bn_notice)) {
            $data->bn_notice = $request->bn_notice;
        }
        if (isset($request->status)) {
            $data->status = $request->status;
        }
        if (isset($request->type)) {
            $data->type = $request->type;
        }

        $data->save();

        return $data;
    }

    public function getLatestNotice($type)
    {
        return Notice::where('status', true)->where('type', $type)->orderBy('id','desc')->first();
    }
}
