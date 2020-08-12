<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Modules\User\Http\Requests\UserCreateRequest;
use Modules\User\Repositories\UserRepository;

class AssetController extends BaseController
{
    /**
     * Store an resource into s3
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
	    $path = Storage::disk('s3')->put($request->get('path'), $request->file, 'public');
	
	    return response()->json(["url" => Storage::disk('s3')->url($path)]);
    }
}