<?php

namespace Modules\Locations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Locations\Http\Requests\CreateDivisionRequest;
use Modules\Locations\Http\Requests\UpdateDivisionRequest;
use Modules\Locations\Repositories\DivisionRepository;

class DivisionController extends Controller
{
    private $repository;

    public function __construct(DivisionRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $divisions = $this->repository->get();
        return view('locations::division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('locations::division.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateDivisionRequest $request)
    {
        $division = $this->repository->create($request);
        return redirect()->route('divisions')->with('success', 'Division created successfully');
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
        $division = $this->repository->findById($id);
        return view('locations::division.edit', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateDivisionRequest $request, $id)
    {
        $division = $this->repository->update($request, $id);
        return redirect()->route('divisions')->with('success', 'Division updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $divisions = $this->repository->delete($id);
        return redirect()->route('divisions')->with('success', 'Division deleted successfully');
    }
}
