@extends('layouts.app')
<style>
    .my-next-button {
        width: 206px;
    }
    .order-summary .prescription-image {
        border: 1px solid #00CE5E ;
        width: 86%;
        height: 174px;
    }
    .prescription-checkbox {
        position: absolute;
        top: 20px;
        right: 40px;
    }
    .prescription-section {
        padding: 50px;
        overflow: hidden;
    }
</style>
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- prescription section -->
    <div class="prescription-section">
        <div class="container">
            <div class="row">
                <div class="col-6 mb-3">
                    <h2>{{ __('text.prescription_upload') }}</h2>
                    <p class="mb-5">{{ __('text.prescription_upload_notice') }}</p>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn--primary px-5" data-toggle="modal" data-target="#prescriptionModal">
                        <i class="fas fa-plus"></i>  {{ __('text.prescription') }}
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="prescriptionModalLabel">{{ __('text.add_prescription') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('prescription.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="patient_name" class="col-form-label">{{ __('text.patient_name') }}:</label>
                                            <input type="text" name="patient_name" class="form-control">
                                            @if ($errors->has('patient_name'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('patient_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">{{ __('text.doctor_name') }}:</label>
                                            <input type="text" class="form-control" name="doctor_name" id="message-text" required>
                                            @if ($errors->has('doctor_name'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('doctor_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">{{ __('text.prescription_date') }}:</label>
                                            <input type="date" class="form-control" name="prescription_date" id="message-text" required>
                                            @if ($errors->has('prescription_date'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('prescription_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">{{ __('text.prescription_image') }}:</label>
                                            <input type="file" name="url" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('text.cancel') }}</button>
                                        <button type="submit" class="btn btn-success">{{ __('text.add_prescription') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @if ($errors->has('prescription_id'))
                        <span class="mt-5 text-danger">
                        <strong>{{ $errors->first('prescription_id') }}</strong>
                        </span>
                    @endif
                </div>
            @if (count($prescriptions) > 0)
                <form id="form" method="post" action="{{ route('prescriptions.id') }}">
                    @csrf
                    <div class="col-12">
                        <div class="row">
                            @foreach($prescriptions as $prescription )
                                <div class="my-box col-12 col-md-6 col-lg-3 mt-3 mb-3 prescription-margin">
                                    <div class="order-summary">
                                        <img class="prescription-image img-fluid"  src="{{ $prescription->url }}" alt="">
                                        <p><h5>Patient: {{ $prescription->patient_name }}</h5></p>
                                        <small>Doctor: {{ $prescription->doctor_name }}</small>
                                        <br>
                                        <small>Date: {{ date('d-m-Y', strtotime($prescription->prescription_date)) }}</small>
                                        <input type="checkbox" class="prescription-checkbox" name="prescription_id[]" value="{{ $prescription->id }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn--primary float-left my-next-button">Next</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#form').validate({ // initialize the plugin
            ignore: [],
            errorClass: "text-danger",
            rules: {
                prescription_id: {
                    required: true
                },
            },
        });

        $(document).ready(function() {
            $('.my-box').click(function(event) {
                if (event.target.type !== 'checkbox') {
                    $(':checkbox', this).trigger('click');
                }
            });
        });
    </script>
@endsection

