<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Entities\CustomerAddress;
use Modules\Prescription\Entities\Models\Prescription;
use Modules\Prescription\Http\Requests\CreatePrescriptionRequest;
use Modules\User\Entities\Models\User;
use Modules\User\Repositories\CustomerRepository;

class CustomerController extends Controller
{
    private $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->repository->userDetails(Auth::user()->id);
        $prescriptions = Prescription::all();
        return view('customer.index', compact('data', 'prescriptions'));
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
        $this->repository->userDetailsUpdate($request, $id);
        return redirect()->back()->with('success', 'User profile successfully updated');
    }

    /**
     * @param Request $request
     */
    public function prescriptionStore (Request $request) {
        $data = $request->only(['patient_name', 'doctor_name', 'prescription_date', 'url', 'user_id']);
        $data['user_id'] = Auth::user()->id;
        Prescription::create($data);

        return redirect()->back()->with('success', 'Prescription successfully Added');
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
