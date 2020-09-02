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

    public function notification()
    {
        $huaweiDevice = 'eIvV3NLdT6I:APA91bGmV4njvbCyrsFpZqAO01aynHkLEnwtPe-TGDoEOehvNQN85DvzzoD2zebjNfP76-_n5d_4eDAZTebaHMYMCBlVy-xMrRLTwCuZP72pSnMmzkwQY5d8KwQzxPi1yRS3v8Ojcvrk';
        $redmiDevice = 'eqvzG493GII:APA91bFX-DLcHuZ0q82f3XHR07DD6VIeuyl7EOz5bsADqKhMm8HNQbV_5owGZqbYAtruoo3jsgoaVyIjmD8dDnzkiFrFq1jMlaKJ7a-VcZL_hGhwqNXySKXKfbI93yRsuyTiDRMrltDe';

        $fcm_token = $huaweiDevice;
        $title = 'Notification title';
        $message = 'demo message';
        return sendPushNotification($fcm_token, $title, $message, $id="");
    }
}
