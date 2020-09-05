<?php

namespace Modules\Prescription\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Prescription\Http\Requests\CreatePrescriptionRequest;
use Modules\Prescription\Repositories\PrescriptionRepository;
use Modules\Prescription\Transformers\PrescriptionTransformer;

class PrescriptionController extends BaseController
{
    private $repository;

    public function __construct(PrescriptionRepository $repository)
    {
        $this->repository =$repository;
    }

    /**
     * Display a listing of the resource.
     * @return \Dingo\Api\Http\Response
     */
    public function customerPrescriptons()
    {
        $user = Auth::user();
        $prescriptions = $this->repository->getCustomerPrescription(Auth::user()->id);

        return $this->response->collection($prescriptions, new PrescriptionTransformer());

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(CreatePrescriptionRequest $request)
    {
        $user = Auth::user();
        $prescription = $this->repository->create($request, $user->id);
        return $this->response->item($prescription, new PrescriptonTransformer());
        // return $prescription;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $prescription = $this->repository->findById($id);
        return $this->response->item($prescription, new PrescriptonTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('prescription::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $prescription = $this->repository->update($request, $id);

        return $this->response->item($prescription, new PrescriptonTransformer());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $prescription = $this->repository->delete($id);

        return responseData('Prescripiton deleted successfully');
    }
}
