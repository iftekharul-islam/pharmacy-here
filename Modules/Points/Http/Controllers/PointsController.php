<?php

namespace Modules\Points\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Points\Http\Requests\CreatePointRequest;
use Modules\Points\Repositories\PointRepository;
use Modules\User\Repositories\UserRepository;

class PointsController extends Controller
{
    private $repository;
    private $userRepository;

    public function __construct(PointRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('points::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $customer = $this->userRepository->getAllCustomer();
        return view('points::create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreatePointRequest $request
     * @return RedirectResponse
     */
    public function store(CreatePointRequest $request)
    {
        $data = $this->repository->createManualPoints($request);
        return redirect()->route('point.create')->with('success', 'Manual Point Creation Successful');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('points::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('points::edit');
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
}
