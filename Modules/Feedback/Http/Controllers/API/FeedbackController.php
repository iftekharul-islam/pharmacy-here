<?php

namespace Modules\Feedback\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Feedback\Http\Requests\CreateFeedbackRequest;
use Modules\Feedback\Repositories\FeedbackRepository;

class FeedbackController extends Controller
{
    private $repository;

    public function __construct(FeedbackRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
//        return view('feedback::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
//        return view('feedback::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateFeedbackRequest $request
     * @return JsonResponse
     */
    public function store(CreateFeedbackRequest $request)
    {
        $customer = Auth::user();
        $data = $this->repository->create($request, $customer->id);

        return responsePreparedData('Feedback saved');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
//        return view('feedback::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
//        return view('feedback::edit');
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

    public function pharmacyAverageRating()
    {
        $pharmacy = Auth::user();

        $data = $this->repository->averageRating($pharmacy->id);

        return responsePreparedData(number_format($data, 1));
    }
}
