<?php

namespace Modules\Products\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Products\Entities\Model\Category;
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
     * @return Response
     */
    public function index()
    {
        $categoryList = $this->repository->all();

        if (! $categoryList) {
            throw new NotFoundHttpException('Category list Not Found');
        }

        $category = Category::paginate(10);
        return $this->response->paginator($category, new CategoryTransformer());
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('products::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CategoryCreateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = $this->repository->create($request);

        if (! $category) {
            throw new StoreResourceFailedException('Category create failed');
        }

        return $this->response->created('/products/categories', $category);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $category = $this->repository->findById($id);

        if (! $category) {
            throw new NotFoundHttpException('Category Not Found');
        }

        return $this->response->item($category, new CategoryTransformer());
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
        return view('products::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $category = $this->repository->delete($id);

        if (! $category) {
            throw new DeleteResourceFailedException('Category Delete Failed');
        }

        return responseData('Category delete successful');
    }
}
