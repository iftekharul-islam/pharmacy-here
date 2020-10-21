<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Address\Entities\CustomerAddress;
use Modules\Address\Repositories\AddressRepository;
use Modules\Locations\Repositories\LocationRepository;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Prescription\Entities\Models\Prescription;
use Modules\Prescription\Http\Requests\CreatePrescriptionRequest;
use Modules\Prescription\Repositories\PrescriptionRepository;
use Modules\User\Entities\Models\User;
use Modules\User\Repositories\CustomerRepository;

class CustomerController extends Controller
{
    private $repository;
    private $prescriptionRepository;
    private $orderRepository;
    private $locationRepository;
    private $addressRepository;

    public function __construct(CustomerRepository $repository,
                                PrescriptionRepository $prescriptionRepository,
                                OrderRepository $orderRepository,
                                LocationRepository $locationRepository,
                                AddressRepository $addressRepository)
    {
        $this->repository = $repository;
        $this->prescriptionRepository = $prescriptionRepository;
        $this->orderRepository = $orderRepository;
        $this->locationRepository = $locationRepository;
        $this->addressRepository = $addressRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->repository->userDetails(Auth::user()->id);
        $addresses = $this->addressRepository->getCustomerAddress(Auth::user()->id);
        $prescriptions = $this->prescriptionRepository->getCustomerPrescriptionWeb(Auth::user()->id);
        $orders = $this->orderRepository->orderListByUserWeb(Auth::user()->id);
        $allLocations = $this->locationRepository->getLocation();

        return view('customer.index', compact('data', 'addresses', 'prescriptions', 'orders', 'allLocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addressStore (Request $request) {

        $data = $request->only(['area_id', 'address', 'user_id']);
        $data['user_id'] = Auth::user()->id;
        CustomerAddress::create($data);

        return redirect()->back()->with('success', 'Address added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
//        return $request->all();
        $this->repository->userDetailsUpdate($request, $id);
        return redirect()->back()->with('success', 'User profile successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
