<?php

namespace Modules\Products\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Products\Entities\Model\Form;
use Modules\Products\Http\Requests\CreateFormRequest;
use Modules\Products\Http\Requests\UpdateFormRequest;
use Modules\Products\Repositories\FormRepository;
use Modules\Products\Transformers\FormTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormController extends BaseController
{
    private $repository;

    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $formList = $this->repository->all();

        if (! $formList) {
            throw new NotFoundHttpException('Form list Not Found');
        }

        $form = Form::paginate(10);

        return $this->response->paginator($form, new FormTransformer());
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateFormRequest $request
     * @return Response
     */
    public function store(CreateFormRequest $request)
    {
        $form = $this->repository->create($request);

        if (! $form) {
            throw new StoreResourceFailedException('Form Create failed');
        }

        return $this->response->created('/forms', $form);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $form = $this->repository->get($id);

        if (! $form) {
            throw new NotFoundHttpException('Form Not Found');
        }

        return $this->response->item($form, new FormTransformer());
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateFormRequest $request
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(UpdateFormRequest $request, $id)
    {
        $form = $this->repository->update($request, $id);

        if (! $form) {
            throw new UpdateResourceFailedException('Form update failed');
        }

        return $this->response->item($form, new FormTransformer());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $form =  $this->repository->delete($id);

        if (! $form) {
            throw new DeleteResourceFailedException('Form Delete Failed');
        }

        return responseData('Form delete successful');
    }
}
