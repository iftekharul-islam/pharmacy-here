@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="order-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="nav flex-column nav-pills my-dashboard" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">My Account</a>
                        <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">My Orders</a>
                        <a class="nav-link" id="v-pills-wishlists-tab" data-toggle="pill" href="#v-pills-wishlists" role="tab" aria-controls="v-pills-wishlists" aria-selected="false">My Prescription</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content my-dashboard-content" id="v-pills-tabContent">

                        <div class="tab-pane show fade active my-account" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                            <h2 class="my-dashboard-title">My Profile</h2>
                                <div class="my-order-list my-design">
                                    <form method="post" action="{{ route('customer.update', $data->id) }}">
                                        @csrf
                                        <input type="hidden" name="addressId" value="{{ $data->customerAddress[0]->id }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Name :</td>
                                                    <td class="save-value">{{ $data->name }}</td>
                                                    <td class="edit-value d-none"><input type="text" name="name" value="{{ $data->name }}"></td>

                                                </tr>
                                                <tr>
                                                    <td>phone number:</td>
                                                    <td class="save-value">{{ $data->phone_number }}</td>
                                                    <td class="edit-value d-none"><input type="text" name="phone_number" value="{{ $data->phone_number }}"></td>
                                                </tr>
                                                    <tr>
                                                        <td>Alter contact :</td>
                                                        <td class="save-value">{{ $data->alternative_phone_number != null ? $data->alternative_phone_number : 'Null' }}</td>
                                                        <td class="edit-value d-none"><input type="text" name="alternative_phone_number" value="{{ $data->alternative_phone_number }}"></td>
                                                    </tr>
                                                <tr>
                                                    <td>Address:</td>
                                                    <td class="save-value">{{ $data->customerAddress[0]->address }}</td>
                                                    <td class="edit-value d-none"><textarea type="text" name="address" value="{{ $data->customerAddress[0]->address }}">{{ $data->customerAddress[0]->address }}</textarea></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-6">
                                            <table class="table table-borderless">
                                                    <tr>
                                                        <td>Date of birth :</td>
                                                        <td class="save-value">{{ $data->dob != null ? $data->dob : "Null" }}</td>
                                                        <td class="edit-value d-none"><input type="date" name="dob"  value="{{ $data->dob }}"></td>
                                                    </tr>
                                                <tr>
                                                    <td>Gender :</td>
                                                    <td class="save-value">{{ $data->gender != null ? $data->gender : "Null" }}</td>
                                                    <td class="edit-value d-none"><input type="text" name="gender" value="{{ $data->gender }}"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary text-white edit-value d-none">Save</button>
                                    <a class="btn btn-primary text-white save-value" onclick="input()">Edit</a>
                                    </form>
                                </div>
                        </div>

                        <div class="tab-pane fade my-orders" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                            <h2 class="my-dashboard-title">My Orders</h2>
                            <div class="my-order-list">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Order #</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Ship To</th>
                                            <th scope="col">Order total</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Confirm</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Complete</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">#1003 </td>
                                            <td>16/09/20 </td>
                                            <td>Rakibul H. Rocky</td>
                                            <td>৳ 2400</td>
                                            <td>Canceled</td>
                                            <td><a href="#">View Order</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade my-wishlists" id="v-pills-wishlists" role="tabpanel" aria-labelledby="v-pills-wishlists-tab">
                            <h2 class="my-dashboard-title">My Prescriptions</h2>
                            <div class="my-order-list">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary float-right mb-2" data-toggle="modal" data-target="#exampleModal">
                                    + Prescription
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Prescription</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" action="{{ route('prescription.store') }}" enctype="multipart/form-data">
                                                @csrf
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Customer name:</label>
                                                        <input type="text" name="patient_name" class="form-control" id="recipient-name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Doctor name:</label>
                                                        <input type="text" class="form-control" name="doctor_name" id="message-text">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Prescription date:</label>
                                                        <input type="date" class="form-control" name="prescription_date" id="message-text">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Prescription Image:</label>
                                                        <input type="file" name="url">
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
                                    <table class="table table-borderless">
                                        <thead class="thead-light">
                                        <tr>
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
                                                <td scope="row">{{ $prescription->url }}</td>
                                                <td>{{ $prescription->patient_name }}</td>
                                                <td>{{ $prescription->doctor_name }}</td>
                                                <td>{{ $prescription->prescription_date }}</td>
                                                <td>Canceled</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <!-- font awesome -->
    <script src="{{ asset('js/icon.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- owl -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- custom jquery -->
    <script src="js/main.js"></script>

    <script type="text/javascript">
        function input(){
            console.log('hello!!!')
            $(".save-value").addClass('d-none');
            $(".edit-value").removeClass('d-none');
        };
    </script>
@endsection
