@extends('layouts.app')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- cart section -->
    <div class="cart-section">
        <div class="container">
            <div class="row">
                <div class="col-6 mb-3">
                    <h2>Upload Prescriptions</h2>
                    <p>Please upload images of valid prescription from your doctor.</p>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary px-5" data-toggle="modal" data-target="#prescriptionModal">
                        <i class="fas fa-plus"></i>  Prescription
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="prescriptionModalLabel">Add Prescription</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('prescription.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="patient_name" class="col-form-label">Patient name:</label>
                                            <input type="text" name="patient_name" class="form-control">
                                            @if ($errors->has('patient_name'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('patient_name') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Doctor name:</label>
                                            <input type="text" class="form-control" name="doctor_name" id="message-text" required>
                                            @if ($errors->has('doctor_name'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('doctor_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Prescription date:</label>
                                            <input type="date" class="form-control" name="prescription_date" id="message-text" required>
                                            @if ($errors->has('prescription_date'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('prescription_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Prescription Image:</label>
                                            <input type="file" name="url" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Prescription</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('prescriptions.id') }}">
                @csrf
            <div class="row mb-5">
                    @foreach($prescriptions as $prescription )
                        <div class="col-3">
                            <div class="order-summary">
                                <div class="row">
                                    <div class="col-10">
                                    <img height="150px" width="120px"  src="{{ $prescription->url }}" alt="">
                                    <h5>Patient: {{ $prescription->patient_name }}</h5>
                                    <p>Doctor: {{ $prescription->doctor_name }}</p><br>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#prescriptionDetailsModal">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="prescriptionDetailsModal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="prescriptionDetailsModalLabel">Prescription Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <img width="250px" height="300px" src="{{ $prescription->url }}" alt="">
                                                            </div>
                                                            <div class="col-6 My-modal">
                                                                <strong>Patient </strong>
                                                                <label>
                                                                    @if (!empty($prescription->patient_name))
                                                                        {{$prescription->patient_name}}
                                                                    @else
                                                                        {{ Auth::user()->name }}
                                                                    @endif
                                                                </label><br>
                                                                <strong>Doctor </strong>
                                                                <label>{{ $prescription->doctor_name }}</label><br>
                                                                <strong>Date</strong>
                                                                <label>{{ date('d-m-Y', strtotime($prescription->prescription_date)) }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <input type="checkbox" class="float-right" name="prescription_id[]" value="{{ $prescription->id }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn--primary float-left px-5">Next</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

