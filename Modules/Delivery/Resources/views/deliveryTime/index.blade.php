{{--@extends('items::layouts.master')--}}
@extends('adminlte::page')

@section('title', 'Delivery Time')

@section('content_header')
    {{--    <h1>Dashboard</h1>--}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $page_title }}</h1>
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
            <h3 class="card-title">{{ $page_title }}</h3>
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
                            <td>{{ date("M", mktime(0, 0, 0, $item['start_month'], 10))  . ' - ' . date("M", mktime(0, 0, 0, $item['end_month'], 10))  }}</td>
                            <td>{{ date("g:i a", strtotime($item['start_time'])). ' - ' . date("g:i a", strtotime($item['end_time'])) }}</td>
                            <td>@include('delivery::deliveryTime.status', ['status' => $item->status])</td>
                            <td>
                                <a href="{{ route('delivery-time-edit', $item['id']) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> </a>
                                {{--                        <a href="{{ route('destroy', $item['id']) }}" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> </a>--}}

                                <form id="delete-form-{{ $loop->index }}" action="{{ route('delivery-time-destroy', $item['id']) }}"
                                      method="post"
                                      class="form-horizontal d-inline">
                                    @method('DELETE')
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
                <p> No {{ $page_title }} Found</p>
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
                    // setTimeout(5000);
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                }
            })
        }


    </script>
@stop


