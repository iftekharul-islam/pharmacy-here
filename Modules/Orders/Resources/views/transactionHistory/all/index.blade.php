@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Transactions</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <!-- @auth("web")
        <h1>Hello world</h1>
{{ Auth::guard('web')->user()->can('create.user') }}

    @endauth -->

    <div class="card col-md-12">
        <div class="card-body">
            <form method="get" action="{{ route('cod.transactionHistory.index') }}">
                <div class="row">
                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>District</label>
                        <select name="district_id" class="form-control" id="selectDistrict" onchange="getThanas(value)">
                            <option value="" selected disabled>Select district</option>
                            @foreach($allLocations as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
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
                    <div class="col-12-xxxl col-lg-12 col-12 form-group">
                        <button type="submit" class="btn btn-primary float-right">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transactions of Pharmacy</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            @if (count($transactionHistories) > 0)
                <table id="example1" class="table  mb-3">
                    <thead>
                    <tr>
                        <th>Pharmacy Name</th>
                        <th>Pharmacy Amount</th>
                        <th>Subidha Amount</th>
                        <th>Paid</th>
                        <th>Payable Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactionHistories as $index => $item)
                        @php
                            $i = 1;
                            $pharmacy_amount = $item->pharmacyOrder[0]->pharmacy_amount ?? 0;
                            $subidha_amount = $item->pharmacyOrder[0]->subidha_amount ?? 0;
                            $amount = $item->pharmacyTransaction[0]->amount ?? 0;
                            $payable = $subidha_amount + $amount;
                        @endphp
                        @if(!empty($pharmacy_amount))
                            <tr>
                                <td>{{ $item->pharmacy_name }}</td>
                                <td>{{ $pharmacy_amount }}</td>
                                <td>{{ $subidha_amount }}</td>
                                <td>{{ $amount }}</td>
                                <td>
                                    @if ($payable > $pharmacy_amount)
                                        + {{ $payable - $pharmacy_amount }}
                                    @else
                                        {{ $payable - $pharmacy_amount }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('transactionHistory.create', $item->user_id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @else
                <h4 class="text-center">No data found !</h4>
            @endif
        </div>
        <!-- /.card-body -->
    </div>

@endsection
{{--@section('js')--}}
{{--    <script>--}}
{{--        var addresses = {!! json_encode($allLocations) !!};--}}
{{--        var thanas = [];--}}
{{--        var areas = [];--}}

{{--        function getThanas() {--}}
{{--            var districtId = $('#selectDistrict option:selected').val();--}}

{{--            var selectedDistrict = addresses.find(address => address.id == districtId);--}}

{{--            thanas = selectedDistrict.thanas;--}}

{{--            if ( thanas.length === 0 ) {--}}
{{--                $('#selectThana').prop('disabled', true );--}}
{{--            }--}}

{{--            $('#selectThana').html('');--}}
{{--            $('#selectThana').append(`<option value="" selected disabled>Please Select a thana</option>`);--}}

{{--            $.map(thanas, function(value) {--}}
{{--                $('#selectThana').removeAttr('disabled');--}}
{{--                $('#selectThana')--}}
{{--                    .append($("<option></option>")--}}
{{--                        .attr("value",value.id)--}}
{{--                        .text(value.name));--}}
{{--            });--}}

{{--        }--}}

{{--        function getAreas() {--}}
{{--            var areaId = $('#selectThana option:selected').val();--}}
{{--            var selectedThana = thanas.find(thana => thana.id == areaId);--}}
{{--            areas = selectedThana.areas;--}}

{{--            if ( areas.length === 0 ) {--}}
{{--                $('#selectArea').attr('disabled', 'disabled');--}}
{{--            }--}}

{{--            $('#selectArea').html('');--}}
{{--            $('#selectArea').append(`<option value="" selected disabled>Please Select an area</option>`);--}}

{{--            $.map(areas, function(value) {--}}
{{--                $('#selectArea').removeAttr('disabled');--}}

{{--                $('#selectArea')--}}
{{--                    .append($("<option></option>")--}}
{{--                        .attr("value",value.id)--}}
{{--                        .text(value.name));--}}
{{--            });--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}

