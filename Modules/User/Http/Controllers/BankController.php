<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CreateBankNameRequest;
use Modules\User\Http\Requests\UpdateBankNameRequest;
use Modules\User\Repositories\BankRepository;

class BankController extends Controller
{
    private $repository;

    public function __construct(BankRepository $repository)
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
//        return $data;
        return view('user::bank.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::bank.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateBankNameRequest $request
     * @return RedirectResponse
     */
    public function store(CreateBankNameRequest $request)
    {
//        return $request->all();
        $item = $this->repository->create($request);
        return redirect()->route('bank.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->repository->get($id);
        return view('user::bank.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateBankNameRequest $request, $id)
    {
        $data = $this->repository->update($request, $id);
        return redirect()->route('bank.index')->with('success', 'Bank updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = $this->repository->delete($id);
        return redirect()->route('bank.index')->with('success', 'Bank deletion successfully');
    }
}
