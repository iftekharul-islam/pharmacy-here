<?php

namespace Modules\Locations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Locations\Http\Requests\CreateDistrictRequest;
use Modules\Locations\Http\Requests\UpdateDistrictRequest;
use Modules\Locations\Repositories\DistrictRepository;
use Modules\Locations\Repositories\DivisionRepository;

class DistrictController extends Controller
{
    private $repository;
    private $divisionRepository;

    public function __construct(DistrictRepository $repository, DivisionRepository $divisionRepository)
    {
        $this->repository = $repository;
        $this->divisionRepository = $divisionRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $districts = $this->repository->get();
        return view('locations::district.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $divisions = $this->divisionRepository->get();
        
        return view('locations::district.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateDistrictRequest $request)
    {
        $district = $this->repository->create($request);
        return redirect()->route('districts');
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
        $district = $this->repository->findById($id);
        $divisions = $this->divisionRepository->get();
        return view('locations::district.edit', compact('district', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateDistrictRequest $request, $id)
    {
        $district = $this->repository->update($request, $id);
        return redirect()->route('districts');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $district = $this->repository->delete($id);
        return redirect()->route('districts');
    }
}
