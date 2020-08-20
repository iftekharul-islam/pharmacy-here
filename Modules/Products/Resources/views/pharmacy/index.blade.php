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
                <!-- <div class="col-sm-6">
                    <a href="{{ route('generic.create') }}" class="btn btn-lg btn-success float-right">
                        Create Product Generic
                    </a>
                </div> -->
            </div>
        </div>
    </section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pharmacies</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Owner</th>
                        <th>Pharmacy Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @if($pharmacies->isNotEmpty())
                    @foreach($pharmacies as $index => $item)
                        <tr>
                            <td>{{ $pharmacies->firstItem() + $index }}</td>
                            <td>{{ $item->name }}</td>
                            <td>@isset($item->pharmacyBusiness) {{ $item->pharmacyBusiness->pharmacy_name }}@endisset</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>{{ $item->email }}</td>
                            <td>@include('products::status', ['status' => $item->status]) </td>
                            <td>
                                <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-eye"></i>
                                </button>
                                @isset($item->pharmacyBusiness)
                                    <a href="{{ route('pharmacy.edit', $item->pharmacyBusiness->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i> </a>
                                    <form id="delete-form-{{ $loop->index }}" action="{{ route('pharmacy.destroy', $item['id']) }}"
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
                                @endisset
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    @include('products::pharmacy.show')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.data-table').dataTable();
        });

        function showProduct(item) {
            console.log(item)
            $('#name').html(item.name);
            $('#pharmacy_name').html(item.pharmacy_business.pharmacy_name);
            $('#phone').html(item.phone_number);
            $('#email').html(item.email);
            $('#address').html(item.pharmacy_business.pharmacy_address);
            $('#bank_account').html(item.pharmacy_business.bank_account_name);
            $('#account_no').html(item.pharmacy_business.bank_account_number);
            $('#bank_name').html(item.pharmacy_business.bank_name);
            $('#branch').html(item.pharmacy_business.bank_brunch_name);
            $('#bkash').html(item.pharmacy_business.bkash_number);
            $('#startTime').html(item.pharmacy_business.start_time);
            $('#endTime').html(item.pharmacy_business.end_time);
            $('#breakStart').html(item.pharmacy_business.break_start_time);
            $('#breakEnd').html(item.pharmacy_business.break_end_time);
            if(item.pharmacy_business.nid_img_path) {
                $('#nid').html('<img src="'+ item.pharmacy_business.nid_img_path +'" width="100" />');
            }
            if(item.pharmacy_business.trade_img_path) {
                $('#trade').html('<img src="'+ item.pharmacy_business.trade_img_path +'" width="100"/>');
            }
            if(item.pharmacy_business.drug_img_path) {
                $('#drug').html('<img src="'+ item.pharmacy_business.drug_img_path +'" width="100" />');
            }
            $('#status').html(checkStatus(item.status));
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

        function checkStatus(status  = 0) {
            return status == 1 ?
                '<button type="button" class="btn btn-success btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-check"></i></button>'
                : '<button type="button" class="btn btn-danger btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-times"></i></button>';
        }
    </script>
@stop

