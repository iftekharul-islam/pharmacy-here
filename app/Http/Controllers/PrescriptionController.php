<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrescriptionSubmitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Prescription\Entities\Models\Prescription;
use Modules\Prescription\Http\Requests\CreatePrescriptionRequest;
use Modules\Prescription\Repositories\PrescriptionRepository;

class PrescriptionController extends Controller
{
    private $prescriptionRepository;

    public function __construct(PrescriptionRepository $prescriptionRepository)
    {
        $this->prescriptionRepository = $prescriptionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prescriptions = $this->prescriptionRepository->getCustomerPrescriptionWeb(Auth::user()->id);
        return view('prescription.create', compact('prescriptions'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectedId(PrescriptionSubmitRequest $request)
    {
        session()->put('prescriptions', $request->prescription_id);

        return redirect()->route('checkout.preview');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrescriptionRequest $request)
    {
        $data = $this->prescriptionRepository->createWeb($request);
        if ($data) {
            return redirect()->back()->with('success', 'Prescription successfully Added');
        }
        return redirect()->back()->with('failed', 'Prescription not successfully Added');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prescription = Prescription::find($id);
        Storage::disk('public')->delete($prescription->url);
        $prescription->delete();
        return redirect()->back()->with('success', 'Prescription successfully Deleted');
    }
}
