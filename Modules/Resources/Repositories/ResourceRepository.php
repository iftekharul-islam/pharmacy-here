<?php


namespace Modules\Resources\Repositories;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
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
//        $data = $request->only('title','bn_title', 'description','bn_description', 'url', 'files');

        $data = new Resource();

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
            $data->bn_description = $request->bn_description;
        }
        if (isset($request->url)) {
            $data->url = $request->url;
        }
        if (isset($request->doc_file)) {
            $path = Storage::disk('public')->put('resource', $request->file('doc_file'));
            $data->files = $path;
        }

        $data->save();
        return $data;


//        return Resource::create($data);
    }

    public function delete($id)
    {
        $data = Resource::find($id);
        if ($data->file) {
            unlink($data->files);
        }
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
            $data->bn_description = $request->bn_description;
        }
        if ($request->has('url') && $request->get('url')) {
            $data->url = $request->url;
        }
//        if ($request->hasFile('files') && $request->get('files')) {
        if (isset($request->files)) {
//            if ($data->files) {
////                File::delete('storage/' . $data->files);
////                Storage::delete($data->files);
////                unlink(Storage::url($data->files));
//                unlink(public_path('storage/' . $data->files));
//            }
            $path = Storage::disk('public')->put('resource', $request->file('files'));
            $data->files = $path;
        }

        $data->save();
        return $data;
    }
}
