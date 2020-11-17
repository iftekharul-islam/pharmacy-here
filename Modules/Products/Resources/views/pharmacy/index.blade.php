{{--@extends('items::layouts.master')--}}
@extends('adminlte::page')

@section('title', 'Pharmacy')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pharmacies</h1>
                </div>
            </div>
        </div>
    </section>
@stop
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pharmacy.index') }}">
                <div class="row">
                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>District</label>
                        <select name="district_id" class="form-control" id="selectDistrict" onchange="getThanas(value)">
                            <option value="" selected disabled>Select district</option>
                            @foreach($allLocations as $district)
                                <option
                                    value="{{ $district->id }}"@isset($display_district) {{ $display_district == $district->id ? 'selected' : '' }} @endisset>{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>Thana</label>
                        <select name="thana_id" class="form-control" id="selectThana" onchange="getAreas()" disabled="">
                        </select>
                    </div>
                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>Area</label>
                        <select class="form-control" id="selectArea" name="area_id" disabled="">
                        </select>
                    </div>
                    <div class="col-12 form-group mg-t-2 float-right">
                        <button type="submit" class="btn btn-primary float-right">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pharmacies</h3> &nbsp;
            <p class="badge badge-primary">{{ $pharmacies->total()}}</p>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive mb-3">
            <table id="example1" class="table">
                <thead>
                <tr>
                    <th>Owner</th>
                    <th>Pharmacy Name</th>
                    <th>Pharmacy Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Created at</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($pharmacies->isNotEmpty())
                    @foreach($pharmacies as $index => $item)
                        <tr>
                            <td>@isset($item->name) {{ $item->name }} @endisset</td>
                            <td>@isset($item->pharmacyBusiness) {{ $item->pharmacyBusiness->pharmacy_name }} @endisset</td>
                            <td>@isset($item->pharmacyBusiness) {{ $item->pharmacyBusiness->pharmacy_address }}
                                ,{{$item->pharmacyBusiness->area->name}}, {{$item->pharmacyBusiness->area->thana->name}}
                                , {{$item->pharmacyBusiness->area->thana->district->name}} @endisset</td>
                            <td>@isset($item->phone_number) {{ $item->phone_number }} @endisset</td>
                            <td>@isset($item->email) {{ $item->email }} @endisset</td>
                            <td>{{ isset($item->pharmacyBusiness->created_at) ? $item->pharmacyBusiness->created_at->diffForHumans() : '' }}</td>
                            <td>
                                @if($item->status == 1)
                                    <a href="javascript:void(0)" class="badge badge-primary">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="badge badge-danger">Inactive</a>
                                @endif
                            </td>
                            <td class="action-portion">
                                <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success"
                                        data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <a href="{{ route('pharmacy.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> </a>

                                <form id="delete-form-{{ $loop->index }}"
                                      action="{{ route('pharmacy.destroy', $item['id']) }}"
                                      method="post"
                                      class="form-horizontal d-inline">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="btn-group">
                                        <button onclick="removeItem({{ $loop->index }})" type="button"
                                                class="btn btn-danger waves-effect waves-light btn-sm align-items-center">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            {{ $pharmacies->appends(Request::all())->links() }}
        </div>
    </div>

    @include('products::pharmacy.show')

@endsection

@section('js')
    <script>
        var addresses = {!! json_encode($allLocations) !!};

        var selectedDistrict = {!! json_encode( $display_district ?? null ) !!};
        var selectedThana = {!! json_encode( $display_thana ?? null ) !!};
        var selectedArea = {!! json_encode($display_area ?? null ) !!};

        var thanas = [];
        var areas = [];

        window.onload = function () {
            if (selectedDistrict != null) {
                getThanas();
                getAreas();
            }
        };

        function getThanas() {
            var districtId = $('#selectDistrict option:selected').val();
            var selectedDistrict = addresses.find(address => address.id == districtId);
            thanas = selectedDistrict.thanas;
            $('#selectThana').html('');
            $('#selectThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

            $.map(thanas, function (value) {
                let selectedvalue = value.id == selectedThana ? true : false;
                $('#selectThana').removeAttr('disabled');
                $('#selectThana')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .prop('selected', selectedvalue)
                        .text(value.name));
            });

        }

        function getPharmacyThanas() {
            var districtId = $('#selectPharmacyDistrict option:selected').val();
            var selectedDistrict = addresses.find(address => address.id == districtId);
            thanas = selectedDistrict.thanas;

            $('#selectPharmacyThana').html('');
            $('#selectPharmacyThana').append(`<option value="" selected disabled>Please Select a thana</option>`);

            $.map(thanas, function (value) {
                $('#selectPharmacyThana')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
            });

        }

        function getAreas() {
            var areaId = $('#selectThana option:selected').val();
            var selectedThanaValue = thanas.find(thana => thana.id == areaId);
            areas = selectedThanaValue.areas;

            if (areas.length === 0) {
                $('#selectArea').attr('disabled', 'disabled');
                $('#address').attr('disabled', 'disabled');
                $('#submit').attr('disabled', 'disabled');
                $('#selectArea').html('');
                return;
            }

            $('#selectArea').html('');

            $('#selectArea').removeAttr('disabled');
            $('#address').removeAttr('disabled');
            $('#submit').removeAttr('disabled');
            $('#selectArea').append(`<option value="" selected disabled>Please Select a area</option>`);
            $.map(areas, function (value) {
                let selected = value.id == selectedArea ? true : false;
                $('#selectArea')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .prop('selected', selectedArea)
                        .text(value.name));
            });
        }

        $(document).ready(function () {
            $('.data-table').dataTable();
        });

        function showProduct(item) {
            console.log(item)
            if (item.name) {
                $('#name').html(item.name);
            }
            if (item.pharmacy_business) {
                $('#pharmacy_name').html(item.pharmacy_business.pharmacy_name);
            }
            if (item.phone_number) {
                $('#phone').html(item.phone_number);
            }
            if (item.email) {
                $('#email').html(item.email);
            }
            if (item.pharmacy_business) {
                $('#address').html(item.pharmacy_business.pharmacy_address);
            }
            if (item.pharmacy_business) {
                $('#bank_account').html(item.pharmacy_business.bank_account_name);
            }
            if (item.pharmacy_business) {
                $('#account_no').html(item.pharmacy_business.bank_account_number);
            }
            if (item.pharmacy_business) {
                $('#bank_name').html(item.pharmacy_business.bank_name);
            }
            if (item.pharmacy_business) {
                $('#branch').html(item.pharmacy_business.bank_brunch_name);
            }
            if (item.pharmacy_business) {
                $('#routing_number').html(item.pharmacy_business.bank_routing_number);
            }
            if (item.pharmacy_business) {
                $('#startTime').html(item.pharmacy_business.start_time);
            }
            if (item.pharmacy_business) {
                $('#endTime').html(item.pharmacy_business.end_time);
            }
            if (item.pharmacy_business) {
                $('#breakStart').html(item.pharmacy_business.break_start_time);
            }
            if (item.pharmacy_business) {
                $('#breakEnd').html(item.pharmacy_business.break_end_time);
            }
            if (item.pharmacy_business && item.pharmacy_business.nid_img_path) {
                $('#nid').html('<img src="' + item.pharmacy_business.nid_img_path + '" width="100" /> <a class="badge badge-primary" href="' + item.pharmacy_business.nid_img_path + '" target="_blank">View Image</a>');
            }
            if (item.pharmacy_business && item.pharmacy_business.trade_img_path) {
                $('#trade').html('<img src="' + item.pharmacy_business.trade_img_path + '" width="100"/> <a class="badge badge-primary" href="' + item.pharmacy_business.trade_img_path + '" target="_blank">View Image</a>');
            }
            if (item.pharmacy_business && item.pharmacy_business.drug_img_path) {
                $('#drug').html('<img src="' + item.pharmacy_business.drug_img_path + '" width="100" /> <a class="badge badge-primary" href="' + item.pharmacy_business.drug_img_path + '" target="_blank">View Image</a>');
            }
        }

        function removeItem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                console.log(result);
                if (result.value) {
                    document.getElementById('delete-form-' + id).submit();
                    setTimeout(5000);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }

        function checkStatus(status = 0) {
            return status == 1 ?
                '<button type="button" class="btn btn-success btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-check"></i></button>'
                : '<button type="button" class="btn btn-danger btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-times"></i></button>';
        }
    </script>
@stop


