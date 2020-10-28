{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Notice')
<style type="text/css">
    .error{
        color: red;
    }
</style>
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="get" action="{{ route('notice.create') }}">
                <div class="row">
                    <div class="col-3-xxxl col-lg-3 col-3 form-group">
                        <label>User type</label>
                        <select class="form-control" name="type" id="type">
                            <option value="1">Pharmacy</option>
                            <option value="2" disabled>Customer</option>
                        </select>
{{--                        <div class="col-3-xxxl col-lg-3 col-3" id="">--}}
{{--                            @if ($errors->has('type'))--}}
{{--                                <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('type') }}</strong>--}}
{{--                                </span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>
                    <div class="col-3-xxxl col-lg-3 col-3 form-group">
                        <label>District</label>
                        <select name="district_id" class="form-control" id="selectDistrict" onchange="getThanas(value)">
                            <option value="" selected disabled>Select district</option>
                            @foreach($allLocations as $district)
                                <option value="{{ $district->id }}" >{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3-xxxl col-lg-3 col-3 form-group">
                        <label>Thana</label>
                        <select name="thana_id" class="form-control" id="selectThana" onchange="getAreas()">

                        </select>
                    </div>
                    <div class="col-3-xxxl col-lg-3 col-3 form-group">
                        <label>Area</label>
                        <select class="form-control" id="selectArea" name="area_id" disabled="">
                        </select>
                    </div>
                    <div class="col-12-xxxl col-lg-12 col-12 form-group">
                        <button type="submit" class="btn btn-primary float-right">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (count($data) > 0)
    <!-- form start -->
    <form role="form" id="form" action="{{ route('notice.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User list</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="example1" class="table  mb-3">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>Area</th>
                    </tr>
                    </thead>
                    @foreach($data as $key=>$item)
                        <input type="hidden" name="pharmacy_id[]" value="{{ $item->id }}">
                        <tbody>
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->pharmacy_name }}</td>
                                <td>Pharmacy</td>
                                <td>{{ $item->area->name }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        @endif
        <div class="col-md-6">
            <div class="card card-primary-outline">
                <div class="card-header">
                    <h3 class="card-title">Create Notice</h3>
                </div>
                <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="notice" class="col-sm-4 col-form-label">Notice</label>
                            <div class="col-sm-8" id="">
                                <input type="text" name="notice" class="form-control" id="notice" placeholder="Notice" required>
                                @if ($errors->has('notice'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('notice') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bn_notice" class="col-sm-4 col-form-label">Notice(Bangla)</label>
                            <div class="col-sm-8  " id="name">
                                <input type="text" name="bn_notice" class="form-control" id="bn_notice" placeholder="Notice(Bangla)" required>
                                @if ($errors->has('bn_notice'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('bn_notice') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8" id="">
                                <select class="form-control" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label">Send Now</label>
                            <div class="col-sm-8" id="">
                                <select class="form-control" name="sendNow" id="sendNow">
                                    <option value="0" selected >No</option>
                                    <option value="1">Yes</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->


                <div class="card-footer">
                    <a href="{{ route('notice.index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $('#form').validate({
            rules: {
                notice: {
                    required: true
                },
                bn_notice: {
                    required: true
                },
            }
        });
        function isNumber(evt)
        {
            // console.log (evt);
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 13 || charCode == 46 || (charCode >= 48 && charCode <= 57))
            {
                return true;
            }
            return false;
        }
        var addresses = {!! json_encode($allLocations) !!};
        var thanas = [];
        var areas = [];

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

        function getAreas() {
            var areaId = $('#selectThana option:selected').val();
            var selectedThana = thanas.find(thana => thana.id == areaId);
            areas = selectedThana.areas;

            if ( areas.length === 0 ) {
                $('#selectArea').attr('disabled', 'disabled');
            }

            $('#selectArea').html('');
            $.map(areas, function(value) {
                $('#selectArea').removeAttr('disabled');

                $('#selectArea')
                    .append($("<option></option>")
                        .attr("value",value.id)
                        .text(value.name));
            });
        }
    </script>
@endsection


