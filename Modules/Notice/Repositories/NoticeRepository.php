<?php


namespace Modules\Notice\Repositories;


use Modules\Notice\Entities\Models\Notice;

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
        $data = $request->only('notice', 'bn_notice', 'status', 'type');

        return Notice::create($data);
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

    public function getLatestNotice($status)
    {
        return Notice::where('status', true)->where('type', $status)->orderBy('id','desc')->first();
    }
}
