<?php

namespace Modules\Resources\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Resources\Http\Requests\CreateResourceRequest;
use Modules\Resources\Http\Requests\UpdateResourceRequest;
use Modules\Resources\Repositories\ResourceRepository;

class ResourcesController extends Controller
{
    private $repository;

    public function __construct(ResourceRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = $this->repository->all();
        return view('resources::index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('resources::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(CreateResourceRequest $request)
    {
        $data = $this->repository->create($request);
        return redirect()->route('resource.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('resources::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->repository->get($id);
        return view('resources::edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateResourceRequest $request, $id)
    {
        $data = $this->repository->update($request, $id);
        return redirect()->route('resource.index')->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = $this->repository->delete($id);
        return redirect()->route('resource.index')->with('success', 'Resource deletion successfully');
    }
}
