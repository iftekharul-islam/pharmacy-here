@extends('adminlte::page')

@section('title', 'Thana')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thana</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('thana.create') }}" class="btn btn-sm btn-success float-right">
                        Create Thana
                    </a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thana List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table mb-3">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Name(Bangla)</th>
                    <th>District</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if($thanas->isNotEmpty())
                        @foreach($thanas as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['bn_name'] }}</td>
                                <td>{{ $item['district']['name'] }}</td>
                                <td>@include('products::status', ['status' => $item->status])</td>
                                <td>
                                    <a href="{{ route('thana.edit', $item['id']) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i> </a>
                                    <form id="delete-form-{{ $loop->index }}" action="{{ route('thana.destroy', $item['id']) }}"
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
                    @endif

                </tbody>
            </table>
            {{ $thanas->links() }}
        </div>
        <!-- /.card-body -->
    </div>

    @include('products::unit.show')

@endsection

@section('js')
    <script>
        // $(document).ready(function () {
        //     $('.data-table').dataTable();
        // });

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


