@extends('adminlte::page')

@section('title', 'Districts')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Districts</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('district.create') }}" class="btn btn-lg btn-success float-right">
                        Create District
                    </a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Districts List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped data-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Name(Bangla)</th>
                    <th>Division</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                   
                    @foreach($districts as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['bn_name'] }}</td>
                            <td>{{ $item['division']['name'] }}</td>
                            <td>@include('products::status', ['status' => $item->status])</td>
                            <td>
                                <button type="button" onclick="showItem({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <a href="{{ route('district.edit', $item['id']) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> </a>
                                <form id="delete-form-{{ $loop->index }}" action="{{ route('district.destroy', $item['id']) }}"
                                    method="post" class="form-horizontal d-inline">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="btn-group">
                                        <button onclick="removeItem({{ $loop->index }})" type="button"
                                                class="btn btn-danger waves-effect waves-light d-flex align-items-center">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    @include('products::unit.show')

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


