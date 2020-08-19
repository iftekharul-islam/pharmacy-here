{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Update Product')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Update Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('update', $product['id']) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    @endif
                    <div class="form-group row">
                        <label for="type" class="col-sm-4 col-form-label">Type</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="type" value="{{ $product->type }}" class="form-control" id="type" placeholder="Type">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control" id="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category_id" class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="category_id" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="generic_id" class="col-sm-4 col-form-label">Generic</label>
                        <div class="col-sm-8" id="status">
                            <select class="form-control" name="generic_id" id="generic_id">
                                @foreach($generics as $generic)
                                    <option value="{{ $generic->id }}">{{ $generic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_id" class="col-sm-4 col-form-label">Form</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="form_id" id="form_id">
                                @foreach($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="manufacturing_company_id" class="col-sm-4 col-form-label">Company</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="manufacturing_company_id" id="manufacturing_company_id">
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="conversion_factor" class="col-sm-4 col-form-label">Conversion Factor</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->conversion_factor}}" onkeypress="return isNumber(event)"
                                   name="conversion_factor" class="form-control"
                                   id="conversion_factor" placeholder="Conversion Factor">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit" class="col-sm-4 col-form-label">Unit</label>
                        <div class="col-sm-8" id="">
                            <input type="text" value="{{ $product->unit }}" onkeypress="return isNumber(event)"
                                   name="unit" class="form-control" id="unit" placeholder="Unit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="primary_unit_id" class="col-sm-4 col-form-label">Primary Unit</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="primary_unit_id" id="primary_unit_id">
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="trading_price" class="col-sm-4 col-form-label">Trading Price</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->trading_price }}" onkeypress="return isNumber(event)"
                                   name="trading_price" class="form-control" id="trading_price" placeholder="Trading Price">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="purchase_price" class="col-sm-4 col-form-label">Purchase Price</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->purchase_price }}" onkeypress="return isNumber(event)"
                                   name="purchase_price" class="form-control" id="purchase_price" placeholder="Purchase Price">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="administration" class="col-sm-4 col-form-label">Administration</label>
                        <div class="col-sm-8" id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->administration }}" name="administration" class="form-control" id="administration" placeholder="Administration">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precaution" class="col-sm-4 col-form-label">Precaution</label>
                        <div class="col-sm-8  " id="precaution">
                            <input type="text" value="{{ $product->productAdditionalInfo->precaution }}" name="precaution" class="form-control" id="precaution" placeholder="Precaution">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="indication" class="col-sm-4 col-form-label">Indication</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->indication }}" name="indication" class="form-control" id="indication" placeholder="Indication">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contra_indication" class="col-sm-4 col-form-label">Contra Indication</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->contra_indication }}" name="contra_indication" class="form-control" id="contra_indication" placeholder="Contra Indication">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="side_effect" class="col-sm-4 col-form-label">Side Effect</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->side_effect }}" name="side_effect" class="form-control" id="side_effect" placeholder="Side Effect">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mode_of_action" class="col-sm-4 col-form-label">Mode Of Action</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->mode_of_action }}" name="mode_of_action" class="form-control" id="mode_of_action" placeholder="Mode Of Action">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="interaction" class="col-sm-4 col-form-label">Interaction</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->interaction }}" name="interaction" class="form-control" id="interaction" placeholder="Interaction">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adult_dose" class="col-sm-4 col-form-label">Adult Dose</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->adult_dose }}" name="adult_dose" class="form-control" id="adult_dose" placeholder="Adult Dose">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="child_dose" class="col-sm-4 col-form-label">Child Dose</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" value="{{ $product->productAdditionalInfo->child_dose }}" name="child_dose" class="form-control" id="child_dose" placeholder="Child Dose">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="renal_dose" class="col-sm-4 col-form-label">Renal Dose</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="renal_dose" value="{{ $product->productAdditionalInfo->renal_dose }}" class="form-control" id="renal_dose" placeholder="Renal Dose">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="is_saleable" class="col-sm-4 col-form-label">Saleable</label>
                        <div class="col-sm-8 " id="">
                            <select class="form-control" name="is_saleable" id="is_saleable">
                                <option value="1" @if ($product->is_saleable == 1) selected @endif>Yes</option>
                                <option value="0" @if ($product->is_saleable == 1) selected @endif>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="status" id="status">
                                <option value="1" @if ($product->status == 1) selected @endif>Active</option>
                                <option value="0" @if ($product->status == 0) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection



