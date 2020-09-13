@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Medicine LIst</div>

                    <div class="card-body">
                        @if (count($data) > 0)
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Serial no</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $index=>$item)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->purchase_price }}</td>

                                        <td>
                                            <a class="btn btn-sm btn-primary mr-3"
                                               href="{{ route('single-product', $item->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-success mr-3"
                                               onclick="addToCart({{ $item }})">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
{{--                                            <button class="btn btn-danger btn-sm" type="button"--}}
{{--                                                    onclick="deleteGame({{ $item->id }})">--}}
{{--                                                <i class="far fa-trash-alt"></i></button>--}}
{{--                                            <form id="delete-form-{{ $item->id }}"--}}
{{--                                                  action="{{ route('product.destroy', $item->id) }}"--}}
{{--                                                  method="post" style="display: none;">--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                            </form>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4 class="text-center">No data found</h4>
                        @endif
{{--                        <div class="col-md">--}}
{{--                            {{ $data->links() }}--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
