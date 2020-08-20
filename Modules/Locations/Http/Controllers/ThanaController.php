<?php

namespace Modules\Locations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Locations\Repositories\DistrictRepository;
use Modules\Locations\Repositories\ThanaRepository;

class ThanaController extends Controller
{
    private $districtRepository, $thanaRepository;
    public function __construct(DistrictRepository $districtRepository, ThanaRepository $thanaRepository)
    {
        $this->districtRepository = $districtRepository;
        $this->thanaRepository = $thanaRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $thanas = $this->thanaRepository->get();
        return view('locations::thana.index', compact('thanas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $districts = $this->districtRepository->get();
        return view('locations::thana.create', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $thana = $this->thanaRepository->create($request);
        return redirect()->route('thana')->with('success', 'Thana created successfully');
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
        $thana = $this->thanaRepository->findById($id);
        $districts = $this->districtRepository->get();
        return view('locations::thana.edit', compact('thana', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $thana = $this->thanaRepository->update($request, $id);
        return redirect()->route('thana')->with('success', 'Thana updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $thana = $this->thanaRepository->delete($id);
        return redirect()->route('thana')->with('success', 'Thana deleted successfully');
    }
}
