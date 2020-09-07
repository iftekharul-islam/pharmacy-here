@extends('adminlte::page')

@section('title', 'Resource')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Resources</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('resource.create') }}" class="btn btn-sm btn-success float-right">
                        Create Resource
                    </a>
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


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resource List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="example1" class="table  mb-3">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Title</th>
{{--                    <th>Title(Bangla)</th>--}}
                    <th>Description</th>
{{--                    <th>Description(Bangla)</th>--}}
{{--                    <th>Link</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>{{ $item['title'] }}</td>
{{--                            <td>{{ $item['bn_title'] }}</td>--}}
                            <td>{{ $item['description'] }}</td>
{{--                            <td>{{ $item['bn_description'] }}</td>--}}
{{--                            <td>{{ $item['url'] }}</td>--}}
                            <td>
                                <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <a href="{{ route('resource.edit', $item['id']) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> </a>
                                <form id="delete-form-{{ $loop->index }}" action="{{ route('resource.destroy', $item['id']) }}"
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
            {{ $data->links() }}
        </div>
        <!-- /.card-body -->
    </div>

    @include('resources::show')

@endsection

@section('js')
    <script>

        function showProduct(item) {
            console.log(item)
            if (item.title) { $('#title').html(item.title);}
            if (item.bn_title) {$('#bn_title').html(item.bn_title); }
            if (item.description) {$('#description').html(item.description); }
            if (item.bn_description) {$('#bn_description').html(item.bn_description); }
            if (item.url) {$('#url').html(item.url); }

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

        // function checkStatus(status  = 0) {
        //     return status == 1 ?
        //         '<button type="button" class="btn btn-success btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-check"></i></button>'
        //         : '<button type="button" class="btn btn-danger btn-sm-status waves-effect waves-light d-flex align-items-center"><i class="fa fa-times"></i></button>';
        // }
    </script>
@stop
