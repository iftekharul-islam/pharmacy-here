{{--@extends('items::layouts.master')--}}
@extends('adminlte::page')

@section('title', 'Products Company')

@section('content_header')
    {{--    <h1>Dashboard</h1>--}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Company</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('company.create') }}" class="btn btn-lg btn-success float-right">Create Product
                        Company</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <style>
        .action-portion {
            display: flex;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product Company List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped data-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companyList as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>@include('products::status', ['status' => $item->status])</td>
                        <td>
                            <div class="action-portion">
                                <button type="button" onclick="showItem({{ $item }})"
                                        class="btn btn-sm btn-success mr-2" data-toggle="modal"
                                        data-target="#modal-default">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <a href="{{ route('company.edit', $item['id']) }}" class="btn btn-sm btn-primary mr-2">
                                    <i class="fa fa-edit"></i> </a>
                                <form id="delete-form-{{ $loop->index }}"
                                      action="{{ route('company.destroy', $item['id']) }}"
                                      method="post"
                                      class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="btn-group">
                                        <button onclick="removeItem({{ $loop->index }})" type="button"
                                                class="btn btn-danger waves-effect waves-light btn-sm align-items-center">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    @include('products::company.show')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.data-table').dataTable();
        });

        function showItem(item) {
            $('#name').html((item.name));
            $('#status').html(checkStatus(item.status));
        }

        function removeItem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showItemCancelButton: true,
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


