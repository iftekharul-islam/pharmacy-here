<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Products\Http\Requests\UpdatePharmacyRequest;
use Modules\Products\Repositories\PharmacyRepository;
use Modules\User\Entities\Models\User;

class PharmacyController extends Controller
{
    private $repository;
    private $locationRepository;

    public function __construct(PharmacyRepository $repository, LocationRepository $locationRepository)
    {
        $this->repository = $repository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $display_area = $request->area_id;
        $display_thana = $request->thana_id;
        $display_district = $request->district_id;
        $allLocations = $this->locationRepository->getLocation();
        $pharmacies = $this->repository->all($request);
        $totalPharmacy = count($pharmacies);
//        return $pharmacies;

        return view('products::pharmacy.index', compact('pharmacies', 'allLocations',
            'display_area', 'display_thana', 'display_district', 'totalPharmacy'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('products::pharmacy.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('products::pharmacy.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $allLocations = $this->locationRepository->getLocation();
        $pharmacy = $this->repository->findById($id);
        return view('products::pharmacy.edit', compact('pharmacy', 'allLocations'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdatePharmacyRequest $request, $id)
    {
        $pharmacy = $this->repository->update($request, $id);
        return redirect()->route('pharmacy.index')->with('success', 'Pharmacy updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $pharmacy = $this->repository->delete($id);
        return redirect()->route('pharmacy.index');
    }
}
