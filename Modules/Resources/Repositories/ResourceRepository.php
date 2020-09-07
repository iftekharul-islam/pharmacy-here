<?php


namespace Modules\Resources\Repositories;


use Modules\Resources\Entities\Models\Resource;

class ResourceRepository
{
    public function all()
    {
        return Resource::orderby('id', 'desc')->paginate(20);
    }

    public function get($id) {
        return Resource::find($id);
    }

    public function create($request) {
        $data = $request->only('title','bn_title', 'description','bn_description', 'url');

        return Resource::create($data);
    }

    public function delete($id)
    {
        $data = Resource::find($id);

        return $data->delete();

    }

    public function update($request, $id)
    {
        $data = Resource::find($id);

        if (isset($request->title)) {
            $data->title = $request->title;
        }
        if (isset($request->bn_title)) {
            $data->bn_title = $request->bn_title;
        }
        if (isset($request->description)) {
            $data->description = $request->description;
        }
        if (isset($request->bn_description)) {
            $data->bn_ssdescription = $request->bn_description;
        }
        if (isset($request->url)) {
            $data->url = $request->url;
        }

        $data->save();
        return $data;
    }
}
