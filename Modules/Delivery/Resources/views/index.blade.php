{{--@extends('items::layouts.master')--}}
@extends('adminlte::page')

@section('title', 'Delivery Time')

@section('content_header')
    {{--    <h1>Dashboard</h1>--}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Normal Delivery Time</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('delivery-time-create') }}" class="btn btn-sm btn-success float-right">Create Delivery Time</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Normal Delivery Time</h3>
        </div>

        <div class="card-body table-responsive mb-3">
            @if($timeList->isNotEmpty())
                <table id="example1" class="table data-table">
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timeList as $item)
                        <tr>
                            <td>{{ $item['start_month'] . ' - ' . $item['end_month'] }}</td>
                            <td>{{ $item['start_time'] . ' - ' . $item['end_time'] }}</td>
                            <td>@include('delivery::status', ['status' => $item->status])</td>
                            <td>
                                {{--                                <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">--}}
                                {{--                                    <i class="fa fa-eye"></i>--}}
                                {{--                                </button>--}}
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
                <p> No {{ $page_title }}} Found</p>
            @endif
        </div>

    </div>


@endsection

@section('js')
    <script>

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


