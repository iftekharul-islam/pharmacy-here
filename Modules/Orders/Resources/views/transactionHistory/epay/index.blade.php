@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>E-pay Transactions</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <!-- @auth("web")
{{ Auth::guard('web')->user()->can('create.user') }}

    @endauth -->
    <div class="card">
        <div class="card-body">
            <form method="get" action="{{ route('transactionHistory.index') }}">
                <div class="row">
                    <div class="col-4-xxxl col-lg-4 col-4 form-group">
                        <label>District</label>
                        <select name="district_id" class="form-control" id="selectDistrict" onchange="getThanas(value)">
                            <option value="" selected disabled>Select district</option>
                            @foreach($allLocations as $district)
                                <option value="{{ $district->id }}" {{ $district_new_id == $district->id ? 'selected' : ''  }}>{{ $district->name }}</option>
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
                    <div class="col-12-xxxl col-lg-12 col-12">
                        <span>Total order amount : <b>{{ $total_order }}</b></span><br>
                        <span>Total pharmacy amount : <b>{{ $total_pharmacy_amount }}</b></span><br>
                        <span>Total paid amount : <b>{{ $total_paid_amount }}</b></span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transactions of Pharmacy</h3>
            <a class="btn btn-success float-right"
               href="{{ route('epay.export.transaction', ['district' => $district_new_id, 'thana' => $thana_new_id, 'area' => $area_new_id]) }}">Export pharmacy transaction
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            @if (count($transactionHistories) > 0)
            <table id="example1" class="table  mb-3">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Pharmacy Name</th>
                    <th>Order Amount</th>
                    <th>Pharmacy Amount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($transactionHistories as $index => $item)
                        <?php $i = 1?>
                        <tr>
                            <td>{{ $i + $index }}</td>
                            <td>{{ $item->pharmacy->pharmacy_name }}</td>
                            <td>{{ $item->pharmacy->pharmacyOrder[0]->customer_amount ?? 0 }}</td>
                            <td>{{ $item->pharmacy->pharmacyOrder[0]->pharmacy_amount ?? 0 }}</td>
                            <td>{{ $item->amount }}</td>
                            @if(isset($item->pharmacy->pharmacyOrder[0]->pharmacy_amount))
                                @if ($item->pharmacy->pharmacyOrder[0]->pharmacy_amount > $item->amount)
                                    <td>{{ $item->amount - $item->pharmacy->pharmacyOrder[0]->pharmacy_amount  }}</td>
                                @else
                                    <td>{{ $item->pharmacy->pharmacyOrder[0]->pharmacy_amount - $item->amount }}</td>
                                @endif
                            @else
                                <td>0</td>
                            @endif
                            <td>
                                <a href="{{ route('transactionHistory.show', $item->pharmacy->user_id) }}" type="button"  class="btn btn-sm btn-success" >
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('transactionHistory.create', $item->pharmacy_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4 class="text-center">No data found !</h4>
            @endif
{{--            {{ $orders->links() }}--}}
        </div>
        <!-- /.card-body -->
    </div>
@endsection
@section('js')
    <script>
        var addresses = {!! json_encode($allLocations) !!};

        var selectedDistrict = {!! json_encode( $district_new_id ?? null ) !!};
        var selectedThana = {!! json_encode( $thana_new_id ?? null ) !!};
        var selectedArea = {!! json_encode($area_new_id ?? null ) !!};

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
</script>
@endsection



