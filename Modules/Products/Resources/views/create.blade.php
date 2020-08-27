{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')
@section('title', 'Create Product')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Create Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="type" class="col-sm-4 col-form-label">Type</label>
                        <div class="col-sm-8" id="">
                            <input type="text" name="type" class="form-control" id="type" placeholder="Type">
                            @if ($errors->has('type'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8  " id="name">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category_id" class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8" id="category">
                            <select class="form-control" name="category_id" id="">
                                <option value="" hidden selected></option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="generic_id" class="col-sm-4 col-form-label">Generic</label>
                        <div class="col-sm-8" id="status">
                            <select class="form-control" name="generic_id" id="">
                                <option value="" hidden selected></option>
                                @foreach($generics as $generic)
                                    <option value="{{ $generic->id }}">{{ $generic->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('generic_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('generic_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_id" class="col-sm-4 col-form-label">Form</label>
                        <div class="col-sm-8" id="status">
                            <select class="form-control" name="form_id" id="">
                                <option value="" hidden selected></option>
                                @foreach($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('form_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('form_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="manufacturing_company_id" class="col-sm-4 col-form-label">Company</label>
                        <div class="col-sm-8" id="status">
                            <select class="form-control" name="manufacturing_company_id" id="">
                                <option value="" hidden selected></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('manufacturing_company_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('manufacturing_company_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="conversion_factor" class="col-sm-4 col-form-label">Conversion Factor</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" onkeypress="return isNumber(event)" name="conversion_factor" class="form-control" id="conversion_factor" placeholder="Conversion Factor">
                            @if ($errors->has('conversion_factor'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('conversion_factor') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit" class="col-sm-4 col-form-label">Unit</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" onkeypress="return isNumber(event)" name="unit" class="form-control" id="unit" placeholder="Unit">
                            @if ($errors->has('unit'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('unit') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="primary_unit_id" class="col-sm-4 col-form-label">Primary Unit</label>
                        <div class="col-sm-8" id="status">
                            <select class="form-control" name="primary_unit_id" id="">
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('primary_unit_id'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('primary_unit_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="trading_price" class="col-sm-4 col-form-label">Trading Price</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" onkeypress="return isNumber(event)" name="trading_price" class="form-control" id="trading_price" placeholder="Trading Price">
                            @if ($errors->has('trading_price'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('trading_price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="purchase_price" class="col-sm-4 col-form-label">Purchase Price</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" onkeypress="return isNumber(event)" name="purchase_price" class="form-control" id="purchase_price" placeholder="Purchase Price">
                            @if ($errors->has('purchase_price'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('purchase_price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="administration" class="col-sm-4 col-form-label">Administration</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="administration" class="form-control" id="administration" placeholder="Administration">
                            @if ($errors->has('administration'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('administration') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precaution" class="col-sm-4 col-form-label">Precaution</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="precaution" class="form-control" id="precaution" placeholder="Precaution">
                            @if ($errors->has('precaution'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('precaution') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="indication" class="col-sm-4 col-form-label">Indication</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="indication" class="form-control" id="indication" placeholder="Indication">
                            @if ($errors->has('indication'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('indication') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contra_indication" class="col-sm-4 col-form-label">Contra Indication</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="contra_indication" class="form-control" id="contra_indication" placeholder="Contra Indication">
                            @if ($errors->has('contra_indication'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('contra_indication') }}</strong>
                                </span>
                            @endif
                        </div>
                    
                    </div>
                    <div class="form-group row">
                        <label for="side_effect" class="col-sm-4 col-form-label">Side Effect</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="side_effect" class="form-control" id="side_effect" placeholder="Side Effect">
                            @if ($errors->has('side_effect'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('side_effect') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mode_of_action" class="col-sm-4 col-form-label">Mode Of Action</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="mode_of_action" class="form-control" id="mode_of_action" placeholder="Mode Of Action">
                            @if ($errors->has('mode_of_action'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('mode_of_action') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="interaction" class="col-sm-4 col-form-label">Interaction</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="interaction" class="form-control" id="interaction" placeholder="Interaction">
                            @if ($errors->has('interaction'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('interaction') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="strength" class="col-sm-4 col-form-label">Strength</label>
                        <div class="col-sm-8" >
                            <input type="text" name="strength" class="form-control" id="strength" placeholder="Strength">
                            @if ($errors->has('strength'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('strength') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adult_dose" class="col-sm-4 col-form-label">Adult Dose</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="adult_dose" class="form-control" id="adult_dose" placeholder="Adult Dose">
                            @if ($errors->has('adult_dose'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('adult_dose') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="child_dose" class="col-sm-4 col-form-label">Child Dose</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="child_dose" class="form-control" id="child_dose" placeholder="Child Dose">
                            @if ($errors->has('child_dose'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('child_dose') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="renal_dose" class="col-sm-4 col-form-label">Renal Dose</label>
                        <div class="col-sm-8  " id="">
                            <input type="text" name="renal_dose" class="form-control" id="renal_dose" placeholder="Renal Dose">
                            @if ($errors->has('renal_dose'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('renal_dose') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="is_saleable" class="col-sm-4 col-form-label">Saleable</label>
                        <div class="col-sm-8 " id="">
                            <select class="form-control" name="is_saleable" id="is_saleable">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @if ($errors->has('is_saleable'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('is_saleable') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="is_prescripted" class="col-sm-4 col-form-label">Is Prescribed</label>
                        <div class="col-sm-8 " id="">
                            <select class="form-control" name="is_prescripted" id="is_prescripted">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @if ($errors->has('is_prescripted'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('is_prescripted') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="is_pre_order" class="col-sm-4 col-form-label">Is Pre Order Allowed</label>
                        <div class="col-sm-8 " id="">
                            <select class="form-control" name="is_pre_order" id="is_pre_order">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @if ($errors->has('is_pre_order'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('is_pre_order') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="min_order_qty" class="col-sm-4 col-form-label">Min Order Qty</label>
                        <div class="col-sm-8 " id="">
                            <input type="number" class="form-control" name="min_order_qty" id="min_order_qty">
                            @if ($errors->has('min_order_qty'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('min_order_qty') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
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

@section('js')
    <script !src="">
        function isNumber(evt)
        {
            // console.log (evt);
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 13 || charCode == 46 || (charCode >= 48 && charCode <= 57))
            {
                return true;
            }
            return false;
        }
    </script>
@endsection


