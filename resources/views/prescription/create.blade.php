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
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2>Create Prescription </h2>
                        </div>
                    </div>
                    <div class="order-summary">
                        <form method="post" {{--action="{{ route('prescription.store') }}"--}} enctype="multipart/form-data">
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
        </div>
    </div>

@endsection


@section('js')
@endsection
