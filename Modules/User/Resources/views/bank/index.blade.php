{{--@extends('items::layouts.master')--}}
@extends('adminlte::page')

@section('title', 'Banks')

@section('content_header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Banks</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('bank.create') }}" class="btn btn-sm btn-success float-right">
                        Create Bank
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Banks</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive mb-3">
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Bank Name</th>
                        <th>Bank Name (Bangla)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td> {{ $item->bank_name }} </td>
                            <td>@isset($item->bn_bank_name) {{ $item->bn_bank_name }} @endisset</td>
                            <td>
                                <button type="button" onclick="showProduct({{ $item }})" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <a href="{{ route('bank.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i> </a>


                                <form id="delete-form-{{ $loop->index }}" action="{{ route('bank.destroy', $item['id']) }}"
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
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            {{ $data->links() }}
        </div>

    </div>

    @include('user::bank.show')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.data-table').dataTable();
        });

        function showProduct(item) {
            console.log(item)
            if (item.bank_name) { $('#bank_name').html(item.bank_name);}
            if (item.bn_bank_name) { $('#bn_bank_name').html(item.bn_bank_name);}
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


