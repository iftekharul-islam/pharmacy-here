<?php

namespace Modules\Notice\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Notice\Http\Requests\CreateNoticeRequest;
use Modules\Notice\Repositories\NoticeRepository;
use Modules\Notice\Transformers\NoticeTransformer;

class NoticeController extends BaseController
{
    private $repository;

    public function __construct(NoticeRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
//        return view('notice::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
//        return view('notice::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(CreateNoticeRequest $request)
    {
        $item = $this->repository->create($request);

        return $this->response->item($item, new NoticeTransformer());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
//        return view('notice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
//        return view('notice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function latestPharmacyNotice()
    {
        $status = 1;
        $item = $this->repository->getLatestNotice($status);

        return $this->response->item($item, new NoticeTransformer());
    }

    public function latestCustomerNotice()
    {
        $status = 2;
        $item = $this->repository->getLatestNotice($status);

        return $this->response->item($item, new NoticeTransformer());
    }
}
