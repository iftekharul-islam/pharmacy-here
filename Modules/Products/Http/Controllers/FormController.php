<?php

namespace Modules\Products\Http\Controllers;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Modules\Products\Http\Requests\CreateFormRequest;
use Modules\Products\Http\Requests\UpdateFormRequest;
use Modules\Products\Repositories\FormRepository;
use Nwidart\Modules\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormController extends Controller
{
    private $repository;

    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $formList = $this->repository->all();

        if (! $formList) {
            throw new NotFoundHttpException('Form list Not Found');
        }

        return view('products::form.index', compact('formList'));
    }

    public function create()
    {
        return view('products::form.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateFormRequest $request
     * @return RedirectResponse
     */
    public function store(CreateFormRequest $request)
    {
        $form = $this->repository->create($request);

        if (! $form) {
            throw new StoreResourceFailedException('Form Create failed');
        }

        return redirect()->route('form.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    public function edit($id)
    {
        $form = $this->repository->get($id);

        if (! $form) {
            throw new NotFoundHttpException('Form Not Found');
        }

        return view('products::form.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateFormRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateFormRequest $request, $id)
    {
        $form = $this->repository->update($request, $id);

        if (! $form) {
            throw new UpdateResourceFailedException('Form update failed');
        }

        return redirect()->route('form.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $form =  $this->repository->delete($id);

        if (! $form) {
            throw new DeleteResourceFailedException('Form Delete Failed');
        }

        return redirect()->route('form.index');
    }
}
