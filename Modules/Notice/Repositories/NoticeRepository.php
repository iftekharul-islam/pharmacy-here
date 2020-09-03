<?php


namespace Modules\Notice\Repositories;


use Modules\Notice\Entities\Models\Notice;

class NoticeRepository
{
    public function all() {

    }

    public function get($id) {

    }

    public function create($request) {
        $data = $request->only('notice', 'bn_notice', 'status', 'type');

        return Notice::create($data);
    }

    public function delete() {

    }

    public function update() {

    }

    public function getLatestNotice($status)
    {
        return Notice::where('status', true)->where('type', $status)->orderBy('id','desc')->first();
    }
}
