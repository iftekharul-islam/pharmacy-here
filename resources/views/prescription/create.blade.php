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
                <div class="col-12">
                        <div class="text-center">
                            <h2>My Prescriptions</h2>
                        </div>
                    <div class="order-summary">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn--primary float-right mb-2" data-toggle="modal" data-target="#prescriptionModal">
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
                                                <label for="recipient-name" class="col-form-label">Customer name:</label>
                                                <input type="text" name="patient_name" class="form-control" id="recipient-name" required>
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
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        @if (count($prescriptions) > 0)
                            <form method="post" action="{{ route('prescriptions.id') }}">
                                @csrf
                                <table class="table table-borderless">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Select</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Patient Name</th>
                                        <th scope="col">Doctor name</th>
                                        <th scope="col">Prescription date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($prescriptions as $prescription )
                                            <tr>
                                                <td><input type="checkbox" name="prescription_id[]" value="{{ $prescription->id }}"></td>
                                                <td><img width="55px" height="60px" src="{{ asset('storage/'. $prescription->url) }}" alt=""></td>
                                                <td>{{ $prescription->patient_name }}</td>
                                                <td>{{ $prescription->doctor_name }}</td>
                                                <td>{{ date('d-m-Y', strtotime($prescription->prescription_date)) }}</td>
                                                <td>
                                                    <button type="button" class="badge btn-primary" data-toggle="modal" data-target="#prescriptionDetailsModal">
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
                                                                            <img width="200px" height="300px" src="{{ asset('storage/'. $prescription->url) }}" alt="">
                                                                        </div>
                                                                        <div class="col-6 My-modal">
                                                                            <strong>Patient </strong>
                                                                            <label>{{ $prescription->patient_name }}</label><br>
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
{{--                                                    <form id="delete-form-{{ $loop->index }}" action="{{ route('prescription.destroy', $prescription->id) }}"--}}
{{--                                                          method="post"--}}
{{--                                                          class="form-horizontal d-inline">--}}
{{--                                                        @method('DELETE')--}}
{{--                                                        {{ csrf_field() }}--}}
{{--                                                        <input type="hidden" name="_method" value="DELETE">--}}
{{--                                                        <div class="btn-group">--}}
{{--                                                            <button onclick="removeItem({{ $loop->index }})" type="button"--}}
{{--                                                                    class="badge btn-danger">--}}
{{--                                                                <i class="fas fa-trash"></i>--}}
{{--                                                            </button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn--primary float-right">Next</button>
                            </form>
                        @else
                            <h4 class="text-center">No data available</h4>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
@endsection
