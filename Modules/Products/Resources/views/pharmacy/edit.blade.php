{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Edit Pharmacy')

@section('content')

    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Update Pharmacy</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('pharmacy.update', $pharmacy->id) }}" enctype="multipart/form-data"
                  method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="pharmacy_name" class="col-sm-4 col-form-label">Pharmacy Name</label>
                        <div class="col-sm-8" id="pharmacy_name">
                            <input type="text" name="pharmacy_name" value="{{ $pharmacy->PharmacyBusiness->pharmacy_name ?? old('pharmacy_name') }}" class="form-control" id="pharmacy_name" placeholder="Pharmacy Name">
                            @if ($errors->has('pharmacy_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pharmacy_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pharmacy_address" class="col-sm-4 col-form-label">District</label>
                        <div class="col-sm-8" id="pharmacy_address">
                            <select class="form-control" id="selectDistrict" onchange="getThanas(value)">
                                <option value="" disabled selected>{{ __('text.select_district') }}</option>
                                @foreach($allLocations as $district)
                                    <option value="{{ $district->id }}" data-details="{{ $district->thanas }}" @isset($pharmacy->PharmacyBusiness->area) {{ $pharmacy->PharmacyBusiness->area->thana->district->id == $district->id ? 'selected' : ''  }} @endisset>{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pharmacy_address" class="col-sm-4 col-form-label">Thana</label>
                        <div class="col-sm-8" id="pharmacy_address">
                            <select class="form-control" id="selectThana" onchange="getAreas()"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pharmacy_address" class="col-sm-4 col-form-label">Area</label>
                        <div class="col-sm-8" id="pharmacy_address">
                            <select class="form-control" id="selectArea" name="area_id" disabled=""></select>
                            @if ($errors->has('area_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('area_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pharmacy_address" class="col-sm-4 col-form-label">Pharmacy Address</label>
                        <div class="col-sm-8" id="pharmacy_address">
                            <input type="text" name="pharmacy_address" value="{{ $pharmacy->PharmacyBusiness->pharmacy_address ?? old('pharmacy_address') }}" class="form-control" id="pharmacy_address" placeholder="Pharmacy Address">
                            @if ($errors->has('pharmacy_address'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pharmacy_address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_account_name" class="col-sm-4 col-form-label">Bank A/C Name</label>
                        <div class="col-sm-8" id="bank_account_name">
                            <input type="text" name="bank_account_name" value="{{ $pharmacy->PharmacyBusiness->bank_account_name ?? old('bank_account_name') }}" class="form-control" id="bank_account_name" placeholder="Bank A/C Name">
                            @if ($errors->has('bank_account_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_account_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_account_number" class="col-sm-4 col-form-label">Bank A/C Number</label>
                        <div class="col-sm-8" id="bank_account_number">
                            <input type="text" name="bank_account_number" value="{{ $pharmacy->PharmacyBusiness->bank_account_number ?? old('bank_account_number') }}" class="form-control" id="bank_account_number" placeholder="Bank A/C Number">
                            @if ($errors->has('bank_account_number'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_account_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_name" class="col-sm-4 col-form-label">Bank Name</label>
                        <div class="col-sm-8" id="bank_name">
                            <input type="text" name="bank_name" value="{{ $pharmacy->PharmacyBusiness->bank_name ?? old('bank_name') }}" class="form-control" id="bank_name" placeholder="Bank Name">
                            @if ($errors->has('bank_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_brunch_name" class="col-sm-4 col-form-label">Branch Name</label>
                        <div class="col-sm-8" id="bank_brunch_name">
                            <input type="text" name="bank_brunch_name" value="{{ $pharmacy->PharmacyBusiness->bank_brunch_name ?? old('bank_brunch_name') }}" class="form-control" id="bank_brunch_name" placeholder="Bank Branch Name">
                            @if ($errors->has('bank_brunch_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_brunch_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bkash_number" class="col-sm-4 col-form-label">Bank Routing Number</label>
                        <div class="col-sm-8" id="bkash_number">
                            <input type="number" name="bank_routing_number" value="{{ $pharmacy->PharmacyBusiness->bank_routing_number ?? old('bank_routing_number') }}" class="form-control" id="bank_routing_number" placeholder="Routing Number">
                            @if ($errors->has('bank_routing_number'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bank_routing_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="start_time" class="col-sm-4 col-form-label">Start Time</label>
                        <div class="col-sm-8" id="start_time">
                            <input type="time" name="start_time" value="{{ $pharmacy->PharmacyBusiness->start_time ?? old('start_time') }}" class="form-control" id="start_time" placeholder="Start Time">
                            @if ($errors->has('start_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('start_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="end_time" class="col-sm-4 col-form-label">End Time</label>
                        <div class="col-sm-8" id="end_time">
                            <input type="time" name="end_time" value="{{ $pharmacy->PharmacyBusiness->end_time ?? old('end_time') }}" class="form-control" id="end_time" placeholder="End Time">
                            @if ($errors->has('end_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('end_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="break_start_time" class="col-sm-4 col-form-label">Break Start Time</label>
                        <div class="col-sm-8" id="break_start_time">
                            <input type="time" name="break_start_time" value="{{ $pharmacy->PharmacyBusiness->break_start_time ?? old('break_start_time') }}" class="form-control" id="break_start_time" placeholder="Break Start Time">
                            @if ($errors->has('break_start_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('break_start_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="break_end_time" class="col-sm-4 col-form-label">Break End Time</label>
                        <div class="col-sm-8" id="break_end_time">
                            <input type="time" name="break_end_time" value="{{ $pharmacy->PharmacyBusiness->break_end_time ?? old('break_end_time') }}" class="form-control" id="break_end_time" placeholder="Break End Time">
                            @if ($errors->has('break_end_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('break_end_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nid_image" class="col-sm-4 col-form-label">NID Image</label>
                        <div class="col-sm-8" id="nid_image">
                            <input type="file" class="form-control" name="nid_img_path">
                            @isset($pharmacy->PharmacyBusiness->nid_img_path)
                                <a href="{{ $pharmacy->PharmacyBusiness->nid_img_path }}" class="badge badge-primary"
                                   target="_blank">Exist image</a>
                            @endisset
                            @if ($errors->has('nid_img_path'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('nid_img_path') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="trade_licence" class="col-sm-4 col-form-label">Trade Licence Image</label>
                        <div class="col-sm-8" id="trade_licence">
                            <input type="file" class="form-control" name="trade_img_path">
                            @isset($pharmacy->PharmacyBusiness->trade_img_path)
                                <a href="{{ $pharmacy->PharmacyBusiness->trade_img_path }}" class="badge badge-primary"
                                   target="_blank">Exist image</a>
                            @endisset
                            @if ($errors->has('trade_img_path'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('trade_img_path') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="drug_licence" class="col-sm-4 col-form-label">Drug Licence Image</label>
                        <div class="col-sm-8" id="drug_licence">
                            <input type="file" class="form-control" name="drug_img_path">
                            @isset($pharmacy->PharmacyBusiness->drug_img_path)
                                <a href="{{ $pharmacy->PharmacyBusiness->drug_img_path }}" class="badge badge-primary"
                                   target="_blank">Exist image</a>
                            @endisset
                            @if ($errors->has('drug_img_path'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('drug_img_path') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="break_end_time" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8" id="break_end_time">
                            <select class="form-control" name="status" id="">
                                <option value="1" {{ $pharmacy->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $pharmacy->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @if ($errors->has('break_end_time'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('break_end_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('pharmacy.index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var addresses = {!! json_encode($allLocations) !!};
        var pharmacy = {!! json_encode($pharmacy) !!};

        if ( pharmacy.pharmacy_business != null) {
            var selectedDistrict = {!! json_encode( isset($pharmacy->PharmacyBusiness) ? $pharmacy->PharmacyBusiness->area->thana->district->id : null) !!};
            var selectedThana = {!! json_encode(isset($pharmacy->PharmacyBusiness) ? $pharmacy->PharmacyBusiness->area->thana->id : null) !!};
            var selectedArea = {!! json_encode(isset($pharmacy->PharmacyBusiness) ? $pharmacy->PharmacyBusiness->area->id : null) !!};
        }

        var thanas = [];
        var areas = [];

        window.onload=function(){
            if (pharmacy.pharmacy_business != null) {
                var districtId = $('#selectDistrict option:selected').val();
                var selectedDistrict = addresses.find(address => address.id == districtId);
                thanas = selectedDistrict.thanas;

                $('#selectThana').html('');
                $('#selectThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

                $.map(thanas, function (value) {
                    let selectedvalue = value.id == selectedThana ? true : false;

                    $('#selectThana')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .prop('selected', selectedvalue)
                            .text(value.name));
                });

                var areaId = $('#selectThana option:selected').val();

                var selectedThanaValues = thanas.find(thana => thana.id == areaId);
                areas = selectedThanaValues.areas;

                if (areas.length === 0) {
                    $('#selectArea').attr('disabled', 'disabled');
                    $('#address').attr('disabled', 'disabled');
                    $('#submit').attr('disabled', 'disabled');
                }

                $('#selectArea').html('');
                $.map(areas, function (value) {
                    let selected = value.id == selectedArea ? true : false;

                    $('#selectArea').removeAttr('disabled');
                    $('#address').removeAttr('disabled');
                    $('#submit').removeAttr('disabled');

                    $('#selectArea')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .prop('selected', selected)
                            .text(value.name));
                });
            }
        };

        function getThanas() {
            var districtId = $('#selectDistrict option:selected').val();

            var selectedDistrict = addresses.find(address => address.id == districtId);

            thanas = selectedDistrict.thanas;

            $('#selectThana').html('');
            $('#selectThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

            $.map(thanas, function(value) {

                $('#selectThana')
                    .append($("<option></option>")
                        .attr("value",value.id)
                        .text(value.name));
            });

        }

        function getPharmacyThanas() {
            var districtId = $('#selectPharmacyDistrict option:selected').val();

            var selectedDistrict = addresses.find(address => address.id == districtId);

            thanas = selectedDistrict.thanas;

            $('#selectPharmacyThana').html('');
            $('#selectPharmacyThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

            $.map(thanas, function(value) {
                $('#selectPharmacyThana')
                    .append($("<option></option>")
                        .attr("value",value.id)
                        .text(value.name));
            });

        }

        function getAreas() {
            var areaId = $('#selectThana option:selected').val();
            var selectedThanaValue = thanas.find(thana => thana.id == areaId);
            areas = selectedThanaValue.areas;

            if ( areas.length === 0 ) {
                $('#selectArea').attr('disabled', 'disabled');
                $('#address').attr('disabled', 'disabled');
                $('#submit').attr('disabled', 'disabled');
            }

            $('#selectArea').html('');
            $.map(areas, function(value) {
                $('#selectArea').removeAttr('disabled');
                $('#address').removeAttr('disabled');
                $('#submit').removeAttr('disabled');

                $('#selectArea')
                    .append($("<option></option>")
                        .attr("value",value.id)
                        .text(value.name));
            });
        }
    </script>
@endsection
