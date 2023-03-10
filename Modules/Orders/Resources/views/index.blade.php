@extends('adminlte::page')
@section('title', 'Orders')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <!-- @auth("web")
        <h1>Hello world</h1>
{{ Auth::guard('web')->user()->can('create.user') }}

    @endauth -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('orders.index') }}">
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

                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>Start date</label>
                        <input name="start_date" type="date" class="form-control"
                               value="{{ $display_Sdate ?? ''  }}">
                    </div>
                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>End date</label>
                        <input name="end_date" type="date" class="form-control"
                               value="{{ $display_Edate ?? ''  }}">
                    </div>
                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>Type</label>
                        <select name="status" class="form-control" id="">
                            <option value="" selected disabled>Select a type</option>
                            <option value="3" {{ $status == 3 ? 'selected' : ''}} >Completed</option>
                            <option value="2" {{ $status == 2 ? 'selected' : '' }}>Processing</option>
                            <option value="0" {{ $status === 0 ? 'selected' : '' }}>Pending</option>
                            <option value="10" {{ $status == 10 ? 'selected' : '' }}>Canceled</option>
                            <option value="9" {{ $status == 9 ? 'selected' : '' }}>On The Way</option>
                            <option value="1" {{ $status == 1 ? 'selected' : '' }}>Accepted</option>
                            <option value="8" {{ $status == 7 ? 'selected' : '' }}>Orphan</option>
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
            <h3 class="card-title">Order List</h3>
            <a class="btn btn-success float-right"
               href="{{ route('export.orders', ['district' => $display_district, 'thana' => $display_thana, 'area' => $display_area, 'toDate' => $display_Sdate, 'endDate' => $display_Edate, 'status' => $status ]) }}">Export orders
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            @if($data->isNotEmpty())
                <table id="example1" class="table  mb-3">
                    <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Pharmacy Name</th>
                        <th>Last pharmacy</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $item->order_no }}</td>
                            <td>{{ $item->pharmacy->pharmacyBusiness['pharmacy_name'] ?? '' }}</td>
                            <td>
                                @if($item->status == 8 && isset($item->orderHistory->pharmacy->pharmacy_name))
                                    {{ $item->orderHistory->pharmacy->pharmacy_name ?? '' }}
                                @endif
                                @if($item->status == 10 && isset($item->orderHistory->pharmacy->pharmacy_name))
                                    {{ $item->orderHistory->pharmacy->pharmacy_name ?? '' }}
                                @endif
                            </td>
                            <td>{{ $item->customer_amount }}</td>
                            <td>{{ $item->order_date }}</td>
                            <td>@include('orders::status', ['status' => $item->status])</td>
                            <td>
                                @if($item->status == 8 && isset($item->orderHistory->pharmacy->pharmacy_name))
                                    <form id="active-form-{{ $loop->index }}"
                                          action="{{ route('active.order',[ 'order_id' => $item->id , 'history_id' => $item->orderHistory->id, 'pharmacy_id' => $item->orderHistory->pharmacy->user_id ]) }}"
                                          method="post"
                                          class="form-horizontal d-inline">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="POST">
                                        <div class="btn-group">
                                            <button onclick="activeItem({{ $loop->index }})" type="button"
                                                    class="btn btn-success waves-effect waves-light btn-sm align-items-center">
                                                Active
                                            </button>
                                        </div>
                                    </form>
                                @endif
                                <a href="{{ route('orders.show', $item->id) }}" type="button"
                                   class="btn btn-sm btn-success">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if($item->status != 10 && isset($item->orderHistory->pharmacy->pharmacy_name))
                                    <form id="cancel-form-{{ $loop->index }}"
                                          action="{{ route('cancel.order', [ 'order_id' => $item->id , 'history_id' => $item->orderHistory->id, 'pharmacy_id' => $item->orderHistory->pharmacy->user_id ]) }}"
                                          method="post"
                                          class="form-horizontal d-inline">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="POST">
                                        <div class="btn-group">
                                            <button onclick="cancelItem({{ $loop->index }})" type="button"
                                                    class="btn btn-danger waves-effect waves-light btn-sm align-items-center">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->appends(Request::all())->links() }}
            @else
                <h3 class="text-center">No data found !!!</h3>
            @endif
        </div>
        <!-- /.card-body -->
    </div>
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
                        .prop('selected', selected)
                        .text(value.name));
            });
        }

        function activeItem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to active this order!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Active it!'
            }).then((result) => {
                if (result.value) {
                    document.getElementById('active-form-' + id).submit();
                    setTimeout(5000);
                    Swal.fire(
                        'Activated!',
                        'Order activation successfull',
                        'success'
                    )
                }
            })
        }

        function cancelItem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to cancel this order!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.value) {
                    document.getElementById('cancel-form-' + id).submit();
                    setTimeout(5000);
                    Swal.fire(
                        'Cancelled!',
                        'Order cancel successful',
                        'success'
                    )
                }
            })
        }
    </script>
@endsection


