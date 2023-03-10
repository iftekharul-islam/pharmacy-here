{{--@extends('items::layouts.master')--}}
@extends('adminlte::page')

@section('title', 'Customer')

@section('content_header')
    @if(session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('failed'))
        <div id="successMessage" class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customers</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('customer.create') }}" class="btn btn-sm btn-success float-right">
                        Create Customer
                    </a>
                </div>
                <!-- <div class="col-sm-6">
                    <a href="{{ route('generic.create') }}" class="btn btn-sm btn-success float-right">
                        Create Pharmacy
                    </a>
                </div> -->
            </div>
        </div>
    </section>
@stop
@section('content')
        <form action="{{ route('customer.index') }}">
            <div class="card col-8-xxxl col-lg-8 col-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Customer Name</label>
                            <input type="search" class="form-control" name="search"
                                   value="{{ Request::get('search') }}">
                        </div>
                        <div class="col-12 form-group float-right">
                            <button type="submit" class="btn btn-primary float-right">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Customers</h3>
            <p class="badge badge-primary ml-2">{{ count($data) }}</p>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive mb-3">
            @if($data->isNotEmpty())
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>@isset($item->name) {{ $item->name }} @endisset</td>
                            <td>@isset($item->phone_number) {{ $item->phone_number }} @endisset</td>
                            <td>@isset($item->email) {{ $item->email }} @endisset</td>
                            <td>
                                @if($item->status == 1)
                                    <a href="javascript:void(0)" class="badge badge-primary">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="badge badge-danger">Inactive</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('customer.show', $item->id) }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form id="delete-form-{{ $loop->index }}" action="{{ route('customer.destroy', $item['id']) }}"
                                    method="post"
                                    class="form-horizontal d-inline">
                                    {{--                            @method('DELETE')--}}
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
                </tbody>
            </table>
                <div class="col-md-12">
                    {{ $data->links() }}
                </div>
            @else
                <p class="text-center">No related data found</p>
            @endif
        </div>

    </div>

{{--    @include('products::pharmacy.show')--}}

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.data-table').dataTable();
        });

        // function showProduct(item) {
        //     console.log(item)
        //     if (item.name) { $('#name').html(item.name);}
        //     if (item.pharmacy_business) { $('#pharmacy_name').html(item.pharmacy_business.pharmacy_name); }
        //     if (item.phone_number) {$('#phone').html(item.phone_number); }
        //     if (item.email) { $('#email').html(item.email); }
        //     if (item.pharmacy_business) {$('#address').html(item.pharmacy_business.pharmacy_address); }
        //     if (item.pharmacy_business) {$('#bank_account').html(item.pharmacy_business.bank_account_name); }
        //     if (item.pharmacy_business) {$('#account_no').html(item.pharmacy_business.bank_account_number); }
        //     if (item.pharmacy_business) {$('#bank_name').html(item.pharmacy_business.bank_name); }
        //     if (item.pharmacy_business) {$('#branch').html(item.pharmacy_business.bank_brunch_name); }
        //     if (item.pharmacy_business) {$('#bkash').html(item.pharmacy_business.bkash_number); }
        //     if (item.pharmacy_business) {$('#startTime').html(item.pharmacy_business.start_time); }
        //     if (item.pharmacy_business) {$('#endTime').html(item.pharmacy_business.end_time); }
        //     if (item.pharmacy_business) {$('#breakStart').html(item.pharmacy_business.break_start_time); }
        //     if (item.pharmacy_business) {$('#breakEnd').html(item.pharmacy_business.break_end_time); }
        //     if(item.pharmacy_business && item.pharmacy_business.nid_img_path) {
        //         $('#nid').html('<img src="'+ item.pharmacy_business.nid_img_path +'" width="100" />');
        //     }
        //     if(item.pharmacy_business && item.pharmacy_business.trade_img_path) {
        //         $('#trade').html('<img src="'+ item.pharmacy_business.trade_img_path +'" width="100"/>');
        //     }
        //     if(item.pharmacy_business && item.pharmacy_business.drug_img_path) {
        //         $('#drug').html('<img src="'+ item.pharmacy_business.drug_img_path +'" width="100" />');
        //     }
        //     // $('#status').html(checkStatus(item.status));
        // }

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

        function checkStatus(status  = 0) {
            return status == 1 ?
                '<button type="button" class="btn btn-success btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-check"></i></button>'
                : '<button type="button" class="btn btn-danger btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-times"></i></button>';
        }
    </script>
@stop


