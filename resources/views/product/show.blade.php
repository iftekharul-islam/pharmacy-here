@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Medicine Details</div>

                    <div class="card-body">

                        <div class="form-group row">
                            <label for="type" class="col-sm-4 col-form-label">Type</label>
                            <div class="col-sm-8" id="">
                                {{ $data->type }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8  " id="name">
                                {{ $data->name }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8" id="">
                                {{ $data->category->name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="generic_id" class="col-sm-4 col-form-label">Generic</label>
                            <div class="col-sm-8" id="status">
                                {{ $data->generic->name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="form_id" class="col-sm-4 col-form-label">Form</label>
                            <div class="col-sm-8" id="">
                                {{ $data->form->name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="manufacturing_company_id" class="col-sm-4 col-form-label">Company</label>
                            <div class="col-sm-8" id="">
                                {{ $data->company->name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="conversion_factor" class="col-sm-4 col-form-label">Conversion Factor</label>
                            <div class="col-sm-8  " id="">
                                {{ $data->conversion_factor}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="primary_unit_id" class="col-sm-4 col-form-label">Unit</label>
                            <div class="col-sm-8" id="">
                                {{ $data->primaryUnit->name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="min_order_qty" class="col-sm-4 col-form-label">Min Order Qty</label>
                            <div class="col-sm-8 " id="">
                                {{$data->min_order_qty}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="purchase_price" class="col-sm-4 col-form-label">Price</label>
                            <div class="col-sm-8  " id="">
                                {{ $data->purchase_price }}
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="administration" class="col-sm-4 col-form-label">Administration</label>
                            <div class="col-sm-8" id="">
                                {{ $data->productAdditionalInfo->administration }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="precaution" class="col-sm-4 col-form-label">Precaution</label>
                            <div class="col-sm-8  " id="precaution">
                                {{ $data->productAdditionalInfo->precaution }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="indication" class="col-sm-4 col-form-label">Indication</label>
                            <div class="col-sm-8  " id="">
                                {{ $data->productAdditionalInfo->indication }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contra_indication" class="col-sm-4 col-form-label">Contra Indication</label>
                            <div class="col-sm-8  " id="">
                                {{ $data->productAdditionalInfo->contra_indication }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="side_effect" class="col-sm-4 col-form-label">Side Effect</label>
                            <div class="col-sm-8  " id="">
                                {{ $data->productAdditionalInfo->side_effect }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mode_of_action" class="col-sm-4 col-form-label">Mode Of Action</label>
                            <div class="col-sm-8  " id="">
                                {{ $data->productAdditionalInfo->mode_of_action }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="interaction" class="col-sm-4 col-form-label">Interaction</label>
                            <div class="col-sm-8  " id="">
                                {{ $data->productAdditionalInfo->interaction }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="strength" class="col-sm-4 col-form-label">Strength</label>
                            <div class="col-sm-8" >
                                {{ $data->strength }}
                            </div>
                        </div>

{{--                        <div class="form-group row">--}}
{{--                            <label for="adult_dose" class="col-sm-4 col-form-label">Adult Dose</label>--}}
{{--                            <div class="col-sm-8  " id="">--}}
{{--                                <input type="text" value="{{ $data->productAdditionalInfo->adult_dose }}" name="adult_dose" class="form-control" id="adult_dose" placeholder="Adult Dose">--}}
{{--                                @if ($errors->has('adult_dose'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('adult_dose') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="child_dose" class="col-sm-4 col-form-label">Child Dose</label>--}}
{{--                            <div class="col-sm-8  " id="">--}}
{{--                                <input type="text" value="{{ $data->productAdditionalInfo->child_dose }}" name="child_dose" class="form-control" id="child_dose" placeholder="Child Dose">--}}
{{--                                @if ($errors->has('child_dose'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('child_dose') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="renal_dose" class="col-sm-4 col-form-label">Renal Dose</label>--}}
{{--                            <div class="col-sm-8  " id="">--}}
{{--                                <input type="text" name="renal_dose" value="{{ $data->productAdditionalInfo->renal_dose }}" class="form-control" id="renal_dose" placeholder="Renal Dose">--}}
{{--                                @if ($errors->has('renal_dose'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('renal_dose') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="description" class="col-sm-4 col-form-label">Description</label>--}}
{{--                            <div class="col-sm-8 " id="">--}}
{{--                                <textarea class="form-control" name="description" id="description" >{{$data->productAdditionalInfo->description}}</textarea>--}}
{{--                                @if ($errors->has('description'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('description') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="is_saleable" class="col-sm-4 col-form-label">Saleable</label>--}}
{{--                            <div class="col-sm-8 " id="">--}}
{{--                                <select class="form-control" name="is_saleable" id="is_saleable">--}}
{{--                                    <option value="1" @if ($data->is_saleable == 1) selected @endif>Yes</option>--}}
{{--                                    <option value="0" @if ($data->is_saleable === 0) selected @endif>No</option>--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('is_saleable'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('is_saleable') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="is_prescripted" class="col-sm-4 col-form-label">Is Prescribed</label>--}}
{{--                            <div class="col-sm-8 " id="">--}}
{{--                                <select class="form-control" name="is_prescripted" id="is_prescripted">--}}
{{--                                    <option value="1" @if ($data->is_prescripted == 1) selected @endif>Yes</option>--}}
{{--                                    <option value="0" @if ($data->is_prescripted == 0) selected @endif>No</option>--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('is_prescripted'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('is_prescripted') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="is_pre_order" class="col-sm-4 col-form-label">Is Pre Order Allowed</label>--}}
{{--                            <div class="col-sm-8 " id="">--}}
{{--                                <select class="form-control" name="is_pre_order" id="is_pre_order">--}}
{{--                                    <option value="1" @if ($data->is_pre_order == 1) selected @endif>Yes</option>--}}
{{--                                    <option value="0" @if ($data->is_pre_order === 0) selected @endif>No</option>--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('is_pre_order'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('is_pre_order') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}



{{--                        <div class="form-group row">--}}
{{--                            <label for="status" class="col-sm-4 col-form-label">Status</label>--}}
{{--                            <div class="col-sm-8" id="">--}}
{{--                                <select class="form-control" name="status" id="status">--}}
{{--                                    <option value="1" @if ($data->status == 1) selected @endif>Active</option>--}}
{{--                                    <option value="0" @if ($data->status == 0) selected @endif>Inactive</option>--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('status'))--}}
{{--                                    <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('status') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}
                    </div>

                    <div class="card-footer">
                        <button type="" class="btn btn-primary">Back</button>
                        <button type="" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Type</label>
                            <div class="col-sm-8 pt-2" id="type">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8 pt-2" id="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8 pt-2" id="category">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Generic</label>
                            <div class="col-sm-8 pt-2" id="generic">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Form</label>
                            <div class="col-sm-8 pt-2" id="form">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Company</label>
                            <div class="col-sm-8 pt-2" id="company">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Conversion Factor</label>
                            <div class="col-sm-8 pt-2" id="conversion_factor">
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label for="inputEmail3" class="col-sm-4 col-form-label">Unit</label>--}}
{{--                            <div class="col-sm-8 pt-2" id="unit">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Unit</label>
                            <div class="col-sm-8 pt-2" id="primary_unit">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Min Order Qty</label>
                            <div class="col-sm-8 pt-2" id="min_order_qty"></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Trading Price</label>
                            <div class="col-sm-8 pt-2" id="trading_price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Purchase Price</label>
                            <div class="col-sm-8 pt-2" id="purchase_price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Administration</label>
                            <div class="col-sm-8 pt-2" id="administration">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Precaution</label>
                            <div class="col-sm-8 pt-2" id="precaution">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Indication</label>
                            <div class="col-sm-8 pt-2" id="indication">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Contra Indication</label>
                            <div class="col-sm-8 pt-2" id="contra_indication">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Side Effect</label>
                            <div class="col-sm-8 pt-2" id="side_effect">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Mode Of Action</label>
                            <div class="col-sm-8 pt-2" id="mode_of_action">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Interaction</label>
                            <div class="col-sm-8 pt-2" id="interaction">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="strength" class="col-sm-4 col-form-label">Strength</label>
                                <div class="col-sm-8 pt-2" id="strength"> </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Adult Dose</label>
                            <div class="col-sm-8 pt-2" id="adult_dose">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Child Dose</label>
                            <div class="col-sm-8 pt-2" id="child_dose">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Renal Dose</label>
                            <div class="col-sm-8 pt-2" id="renal_dose">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8 pt-2" id="description">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Saleable</label>
                            <div class="col-sm-8 pt-2" id="is_saleable">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Is Prescribed</label>
                            <div class="col-sm-8 pt-2" id="is_prescripted"></div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Is Pre Order Allowed</label>
                            <div class="col-sm-8 pt-2" id="is_pre_order"></div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8 pt-2" id="status">

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
