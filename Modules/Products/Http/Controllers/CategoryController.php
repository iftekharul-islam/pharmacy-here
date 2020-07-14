<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Modules\Products\Http\Requests\UpdateCategoryRequest;
use Modules\Products\Repositories\CategoryRepository;
use Modules\Products\Http\Requests\CategoryCreateRequest;
use Modules\Products\Transformers\CategoryTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends BaseController
{

    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $categoryList = $this->repository->all();

        if (! $categoryList) {
            throw new NotFoundHttpException('Category list Not Found');
        }

        return view('products::category.index', compact('categoryList'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('products::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = $this->repository->create($request);

        if (! $category) {
            throw new StoreResourceFailedException('Category create failed');
        }

        return redirect()->route('category.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    public function showBySlug($slug)
    {
        $category = $this->repository->findBySlug($slug);

        if (! $category) {
            throw new NotFoundHttpException('Category Not Found');
        }

        return $this->response->item($category, new CategoryTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->repository->findById($id);

        if (! $category) {
            throw new NotFoundHttpException('Category Not Found');
        }

        return view('products::category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->repository->update($request, $id);

        if (! $category) {
            throw new UpdateResourceFailedException('Category update failed');
        }

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $category = $this->repository->delete($id);

        if (! $category) {
            throw new DeleteResourceFailedException('Category Delete Failed');
        }

        return redirect()->route('category.index');
    }
}
