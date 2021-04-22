{{--@extends('items::layouts.master')--}}
@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
{{--    <h1>Dashboard</h1>--}}
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Products <span class="badge badge-success">{{ $productList->total() }}</span></h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('create') }}" class="btn btn-sm btn-success float-right">Create Product</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <form action="{{ route('index') }}">
    <div class="card col-8-xxxl col-lg-8 col-8">
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    <label>Product Name</label>
                    <input type="search" class="form-control" name="medicine" value="{{ request()->get('medicine') }}"
                           placeholder="Search medicine">
                </div>
                <div class="col-12 form-group float-right">
                    <button type="submit" class="btn btn-primary float-right">Search</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product List</h3>
        </div>

        <div class="card-body table-responsive mb-3">
            @if(count($productList) > 0)
            <table id="example1" class="table data-table">
                <thead>
                <tr>
{{--                    <th>Type</th>--}}
                    <th>Name</th>
                    <th>Company</th>
                    <th>Purchase Price</th>
                    <th>Saleable</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productList as $item)
                <tr>
{{--                    <td>{{ $item['type'] }}</td>--}}
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['category']['name'] }}</td>
                    <td>{{ $item['purchase_price'] }}</td>
                    <td>@include('products::status', ['status' => $item->is_saleable])</td>
                    <td>@include('products::status', ['status' => $item->status])</td>
                    <td>
                        <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                            <i class="fa fa-eye"></i>
                        </button>
                        <a href="{{ route('edit', $item['id']) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i> </a>
{{--                        <a href="{{ route('destroy', $item['id']) }}" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> </a>--}}

                        <form id="delete-form-{{ $loop->index }}" action="{{ route('destroy', $item['id']) }}"
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
            @else
                <p> No Product Found</p>
            @endif
        </div>
        <div class="col-md">
            {{ $productList->links() }}
        </div>
    </div>

    @include('products::show')

@endsection

@section('js')
    <script>
        // $(document).ready(function () {
        //     $('.data-table').dataTable();
        // });

        function showProduct(item) {
            $('#name').html((item.name));
            $('#strength').html(item.strength);
            $('#category').html((item.category.name));
            $('#generic').html((item.generic.name));
            $('#form').html((item.form.name));
            $('#company').html((item.company.name));
            $('#conversion_factor').html((item.conversion_factor));
            $('#primary_unit').html((item.primary_unit.name));
            $('#trading_price').html((item.trading_price));
            $('#purchase_price').html((item.purchase_price));
            $('#is_prescripted').html(checkStatus(item.is_prescripted));
            $('#is_pre_order').html(checkStatus(item.is_pre_order));
            $('#min_order_qty').html(item.min_order_qty);
            $('#status').html(checkStatus(item.status));
            $('#unit').html((item.unit));
            // $('#is_saleable').html(checkStatus(item.is_saleable));
            // $('#administration').html((item.product_additional_info.administration));
            // $('#precaution').html((item.product_additional_info.precaution));
            // $('#indication').html((item.product_additional_info.indication));
            // $('#contra_indication').html((item.product_additional_info.contra_indication));
            // $('#side_effect').html((item.product_additional_info.side_effect));
            // $('#mode_of_action').html((item.product_additional_info.mode_of_action));
            // $('#interaction').html((item.product_additional_info.interaction));
            // $('#adult_dose').html((item.product_additional_info.adult_dose));
            // $('#child_dose').html((item.product_additional_info.child_dose));
            // $('#renal_dose').html((item.product_additional_info.renal_dose));
            // $('#description').html((item.product_additional_info.description));
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


