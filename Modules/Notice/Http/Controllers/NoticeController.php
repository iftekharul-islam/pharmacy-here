<?php

namespace Modules\Notice\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Notice\Http\Requests\CreateNoticeRequest;
use Modules\Notice\Http\Requests\UpdateNoticeRequest;
use Modules\Notice\Repositories\NoticeRepository;

class NoticeController extends Controller
{
    private $repository;
    private $locationRepository;

    public function __construct(NoticeRepository $repository, LocationRepository $locationRepository)
    {
        $this->repository = $repository;
        $this->locationRepository = $locationRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = $this->repository->all();
        return view('notice::index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $display_area = $request->area_id;
        $display_thana = $request->thana_id;
        $display_district = $request->district_id;

        $allLocations = $this->locationRepository->getLocation();
        $data = $this->repository->getUserList($request);
        return view('notice::create', compact('allLocations', 'data', 'display_area', 'display_thana', 'display_district'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(CreateNoticeRequest $request)
    {
        $item = $this->repository->create($request);
        return redirect()->route('notice.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->repository->showById($id);
//        return $data;
        return view('notice::show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->repository->get($id);
        return view('notice::edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateNoticeRequest $request, $id)
    {
        $data = $this->repository->update($request, $id);
        return redirect()->route('notice.index')->with('success', 'Notice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = $this->repository->delete($id);
        return redirect()->route('notice.index')->with('success', 'Notice deletion successfully');
    }
}
