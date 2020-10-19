@extends('layouts.app')
<style>
    .My-modal {
        text-align: left;
    }
    .my-address {
        width: fit-content;
        margin-left: auto;
    }
    .save-profile-btn {
        border: 1px solid #00ce5e;
    }
</style>
@section('content')
    @if(session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('failed'))
        <div id="successMessage" class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <div class="order-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="nav flex-column nav-pills my-dashboard" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">{{ __('text.my_profile') }}</a>
                        <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">{{ __('text.my_order') }}</a>
                        <a class="nav-link" id="v-pills-wishlists-tab" data-toggle="pill" href="#v-pills-wishlists" role="tab" aria-controls="v-pills-wishlists" aria-selected="false">{{ __('text.my_prescription') }}</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content my-dashboard-content" id="v-pills-tabContent">
                        <div class="tab-pane show fade active my-account" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                            <h2 class="my-dashboard-title">{{ __('text.my_profile') }}</h2>
                            <a href="#" class="btn btn--primary mb-2 my-address d-block" data-toggle="modal" data-target="#addressModal">
                                <i class="fas fa-plus-circle"></i>
                                <span>{{ __('text.address') }}</span>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addressModalLabel">{{ __('text.new_address') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ route('customer.address.store') }}">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="district" class="col-form-label">{{ __('text.district') }}</label>
                                                    <select class="form-control" id="selectDistrict" onchange="getThanas(value)">
                                                        <option value="" disabled selected>{{ __('text.select_district') }}</option>
                                                        @foreach($allLocations as $district)
                                                            <option value="{{ $district->id }}" >{{ $district->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="thana" class="col-form-label">{{ __('text.thana') }}</label>
                                                    <select class="form-control" id="selectThana" onchange="getAreas()">

                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="area" class="col-form-label">{{ __('text.area') }}</label>
                                                    <select class="form-control" id="selectArea" name="area_id" disabled="">
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address" class="col-form-label">{{ __('text.address') }}</label>
                                                    <input type="text" name="address" class="form-control" id="address" disabled="" required>
                                                    @if ($errors->has('address'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('address') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('text.cancel') }}</button>
                                            <button type="submit" class="btn btn-success" id="submit" disabled="">{{ __('text.save') }}</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form method="post" action="{{ route('customer.update', $data->id) }}">
                            @csrf
                                <input type="hidden" name="addressId" value="{{ isset($data->customerAddress[0]) == true ?  $data->customerAddress[0]->id : null }}">
                                <div class="my-order-list my-profile">
                                    <div class="table-responsive">
                                        <table>
                                            <tr>
                                                <td><b>{{ __('text.name') }}:</b></td>
                                                <td class="save-value">{{ $data->name }}</td>
                                                <td class="edit-value d-none"><input type="text" name="name" value="{{ $data->name }}"></td>
                                                <td><b>{{ __('text.date_of_birth') }}:</b></td>
                                                <td class="save-value">{{ $data->dob != null ? $data->dob : '' }}</td>
                                                <td class="edit-value d-none"><input type="date" name="dob"  value="{{ $data->dob }}"></td>

                                            </tr>
                                            <tr>
                                                <td><b>{{ __('text.phone_number') }}:</b></td>
                                                <td class="save-value">{{ $data->phone_number }}</td>
                                                <td class="edit-value d-none"><input type="text" name="phone_number" value="{{ $data->phone_number }}"></td>
                                                <td><b>{{ __('text.gender') }}:</b></td>
                                                <td class="save-value">{{ $data->gender != null ? $data->gender : '' }}</td>
                                                <td class="edit-value d-none"><input type="text" name="gender" value="{{ $data->gender }}"></td>
                                            </tr>
                                            <tr>
                                                <td><b>{{ __('text.alter_contact') }}:</b></td>
                                                <td class="save-value">{{ $data->alternative_phone_number }}</td>
                                                <td class="edit-value d-none"><input type="text" name="alternative_phone_number" value="{{ $data->alternative_phone_number }}"></td>
                                            </tr>
                                            <tr>
                                                <td><b>{{ __('text.address') }}:</b></td>
                                                <td class="save-value">{{ isset($data->customerAddress[0]) == true ?  $data->customerAddress[0]->address : null }}</td>
                                                <td class="edit-value d-none"><textarea type="text" name="address" value="{{ isset($data->customerAddress[0]) == true ?  $data->customerAddress[0]->address : null }}">{{ isset($data->customerAddress[0]) == true ?  $data->customerAddress[0]->address : null }}</textarea></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="profile-btn">
                                    <a href="javascript:void(0)" class="btn--edit" onclick="input()">{{ __('text.edit') }}</a>
                                    <button type="submit" class="btn-success save-profile-btn">{{ __('text.save') }}</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade my-orders" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                            <h2 class="my-dashboard-title">{{ __('text.my_order') }}</h2>
                            <div class="my-order-list">
                                <div class="table-responsive">
                                    @if (count($orders) > 0)
                                    <table class="table table-borderless">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('text.order') }} #</th>
                                            <th scope="col">{{ __('text.date') }}</th>
                                            <th scope="col">{{ __('text.total') }}</th>
                                            <th scope="col">{{ __('text.status') }}</th>
                                            <th scope="col">{{ __('text.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td scope="row">#{{ $order->order_no }}</td>
                                                    <td>{{ date('d F Y', strtotime($order->order_date)) }}</td>
                                                    <td>৳ {{ $order->amount + $order->delivery_charge }}</td>
                                                    <td>
                                                        @if ($order->status == 0)
                                                            <span class="badge badge-danger">Pending</span>
                                                        @elseif ($order->status == 1)
                                                            <span class="badge badge-warning">Accepted</span>
                                                        @elseif ($order->status == 2)
                                                            <span class="badge" style="background: #FFFF00">Processing</span>
                                                        @elseif ($order->status == 3)
                                                            <span class="badge badge-success">Completed</span>
                                                        @elseif ($order->status == 4)
                                                            <span class="badge badge-info">Failed</span>
                                                        @elseif ($order->status == 5)
                                                            <span class="badge badge-danger">Rejected By Pharmacy</span>
                                                        @elseif ($order->status == 6)
                                                            <span class="badge badge-info">Forwarded</span>
                                                        @elseif ($order->status == 7)
                                                            <span class="badge badge-danger">Expired</span>
                                                        @elseif ($order->status == 8)
                                                            <span class="badge badge-info">Orphan</span>
                                                        @elseif ($order->status == 9)
                                                            <span class="badge badge-info">On The Way</span>
                                                        @elseif ($order->status == 10)
                                                            <span class="badge badge-danger">Cancel</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('order.details', $order->id)}}">
                                                            {{ __('text.view') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <h4 class="text-center">{{ __('text.no_data') }}</h4>
                                    @endif
                                </div>
                                {{ $orders->links() }}
                            </div>
                        </div>

                        <div class="tab-pane fade my-wishlists" id="v-pills-wishlists" role="tabpanel" aria-labelledby="v-pills-wishlists-tab">
                            <h2 class="my-dashboard-title">{{ __('text.my_prescription') }}
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn--primary float-right mb-2" data-toggle="modal" data-target="#prescriptionModal">
                                    <i class="fas fa-plus"></i>  {{ __('text.prescription') }}
                                </button>
                            </h2>
{{--                            <div class="my-order-list">--}}
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
                                                        <label class="col-form-label">{{ __('text.patient_name') }}:</label>
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
                                                <button type="submit" class="btn btn-success">{{ __('text.save') }}</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="container">--}}
                                    @if (count($prescriptions) > 0)
                                        <div class="my-row row mb-3">
                                            @foreach($prescriptions as $prescription )
                                                <div class="my-box col-4 mt-4">
                                                    <div class="order-summary">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <img height="150px" width="150px" class="prescription-image"  src="{{ $prescription->url }}" alt="">
                                                                <strong>Patient: {{ $prescription->patient_name }}</strong><br>
                                                                <small>Doctor: {{ $prescription->doctor_name }}</small>
                                                                <br>
                                                                <button type="button" class="btn btn--primary px-5 w-89 mt-3" data-toggle="modal" data-target="#prescriptionDetailsModal-{{$prescription->id}}">
                                                                    {{ __('text.view') }}
                                                                </button>
                                                                <div class="modal fade" id="prescriptionDetailsModal-{{$prescription->id}}" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalLabel" aria-hidden="true">
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
                                                                                    <div class="col-6 mb-3">
                                                                                        <img width="200px" height="250px" src="{{ $prescription->url }}" alt="">
                                                                                    </div>
                                                                                    <div class="col-6 My-modal">
                                                                                        <strong>Patient </strong>
                                                                                        <label> {{$prescription->patient_name}}</label><br>
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
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <h4 class="text-center">{{ __('text.no_data') }}</h4>
                                    @endif
                            </div>
                            {{ $prescriptions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('.nav-pills a[href="' + activeTab + '"]').tab('show');
            }
        });

        function input(){
            $(".save-value").addClass('d-none');
            $(".edit-value").removeClass('d-none');
        };

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
