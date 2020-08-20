<?php

namespace Modules\Locations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Locations\Http\Requests\CreateAreaRequest;
use Modules\Locations\Http\Requests\UpdateAreaRequest;
use Modules\Locations\Repositories\ThanaRepository;
use Modules\Locations\Repositories\AreaRepository;

class AreaController extends Controller
{
    private $areaRepository, $thanaRepository;
    
    public function __construct(AreaRepository $areaRepository, ThanaRepository $thanaRepository)
    {
        $this->areaRepository = $areaRepository;
        $this->thanaRepository = $thanaRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $areas = $this->areaRepository->get();
        return view('locations::area.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $thanas = $this->thanaRepository->get();
        return view('locations::area.create', compact('thanas'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateAreaRequest $request)
    {
        $area = $this->areaRepository->create($request);
        return redirect()->route('areas');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('locations::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $thanas = $this->thanaRepository->get();
        $area = $this->areaRepository->findById($id);
        return view('locations::area.edit', compact('thanas', 'area'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAreaRequest $request, $id)
    {
        $area = $this->areaRepository->update($request, $id);
        return redirect()->route('areas')->with('success', 'Area updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $area = $this->areaRepository->delete($id);
        return redirect()->route('areas')->with('success', 'Area deleted successfully');
    }
}
