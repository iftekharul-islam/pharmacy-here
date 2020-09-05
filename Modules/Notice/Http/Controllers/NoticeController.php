<?php

namespace Modules\Notice\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notice\Http\Requests\CreateNoticeRequest;
use Modules\Notice\Http\Requests\UpdateNoticeRequest;
use Modules\Notice\Repositories\NoticeRepository;

class NoticeController extends Controller
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
        $data = $this->repository->all();
        return view('notice::index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('notice::create');
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
        return view('notice::show');
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
