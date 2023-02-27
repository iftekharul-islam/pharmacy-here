<?php

namespace Modules\Address\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Http\Requests\CreateAddressRequest;
use Modules\Address\Http\Requests\UpdateAddressRequest;
use Modules\Address\Repositories\AddressRepository;
use Modules\Address\Transformers\AddressTransformer;

class AddressController extends BaseController
{
    private $repository;

    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function customerAddresses(Request $request)
    {
        $addresses = $this->repository->get($request->user()->id);
        return $this->response->collection($addresses, new AddressTransformer);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(CreateAddressRequest $request)
    {
        return $this->repository->create($request, $request->user()->id);
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
        return view('address::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('address::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAddressRequest $request, $id)
    {
        $address = $this->repository->update($request, $id);
        return $this->response->item($address, new AddressTransformer);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $address = $this->repository->delete($id);

        return responseData('Address deleleted successfully');
    }
}
