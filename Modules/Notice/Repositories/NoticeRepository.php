<?php


namespace Modules\Notice\Repositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Notice\Entities\Models\Notice;
use Modules\Notice\Entities\UserNotice;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\TransactionHistory;
use Modules\User\Entities\Models\PharmacyBusiness;
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

    public function showById($id)
    {
        return Notice::with('UserNotices', 'UserNotices.User', 'UserNotices.Pharmacy.area')->where('id', $id)->first();
    }

    public function getUserList($request)
    {
        if ($request->type == 2) {
            return User::where('is_pharmacy', '!=', 1)->where('is_admin', '!=', 1)->where('status', 1)->paginate(config('subidha.item_per_page'));
        } else {
            $pharmacy = PharmacyBusiness::query();

            if ($request->area_id !== null) {
                $pharmacy->whereHas('area', function ($query) use ($request) {
                    $query->where('area_id', $request->area_id);
                });
            }
            if ($request->thana_id !== null && $request->area_id == null) {
                $pharmacy->whereHas('area.thana', function ($query) use ($request) {
                    $query->where('thana_id', $request->thana_id);
                });
            }
            if ($request->district_id !== null && $request->thana_id == null && $request->area_id == null) {
                $pharmacy->whereHas('area.thana.district', function ($query) use ($request) {
                    $query->where('district_id', $request->district_id);
                });
            }
            return $pharmacy->with('area')->paginate(config('subidha.item_per_page'));
        }
    }

    public function create($request)
    {

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

        foreach ($request->user_id as $id) {
            UserNotice::create([
                'notice_id' => $data->id,
                'pharmacy_id' => $id,
                'author_id' => Auth::user()->id,
            ]);
        }

        if ($request->sendNow) {

            if ($request->type == 1) {
                $users = User::whereHas('roles', function ($q) {
                    $q->where('name', 'pharmacy');
                })->get()->pluck('id');
            } else {
                $users = User::whereHas('roles', function ($q) {
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
        return Notice::where('status', true)->where('type', $type)->orderBy('id', 'desc')->first();
    }
}
