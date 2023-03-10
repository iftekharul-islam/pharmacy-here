@extends('adminlte::page')

@section('adminlte_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
      .select2-container .select2-selection--single{height:auto;}
      .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 1;}
  </style>
@endsection

@section('title', 'Create Resource')
<style type="text/css">
    .error{
        color: red;
    }
</style>
@section('content')

    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Create Resource</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="form" action="{{ route('resource.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-sm-5 col-form-label">Title(English)</label>
                        <div class="col-sm-7" id="">
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="title" placeholder="Resource Title" required>
                            @if ($errors->has('title'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_title" class="col-sm-5 col-form-label">Title(Bangla)</label>
                        <div class="col-sm-7" id="">
                            <input type="text" name="bn_title" class="form-control" value="{{ old('bn_title') }}" id="bn_title" placeholder="Resource Title(Bangla)" required>
                            @if ($errors->has('bn_title'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bn_title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-sm-5 col-form-label">Description(English)</label>
                        <div class="col-sm-7" id="">
                            <textarea type="text" name="description" class="form-control" id="description" placeholder="Resource Description" required></textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bn_description" class="col-sm-5 col-form-label">Description(Bangla)</label>
                        <div class="col-sm-7" id="">
                            <textarea type="text" name="bn_description" class="form-control" id="bn_description" placeholder="Resource Description(Bangla)" required></textarea>
                            @if ($errors->has('bn_description'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bn_description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="url" class="col-sm-5 col-form-label">Link</label>
                        <div class="col-sm-7" id="">
                            <input type="text" name="url" class="form-control validategroup" id="url" placeholder="Link">
                            @if ($errors->has('url'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="doc_file" class="col-sm-5 col-form-label">File</label>
                        <div class="col-sm-7" id="">
                            <input type="file" name="doc_file" class="form-control validategroup" id="doc_file">
                            @if ($errors->has('files'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('files') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('adminlte_js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
     $(document).ready(function() {
            $('.select2').select2();
        });
</script>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
        $(document).ready(function() {
            alert('new alert');
            $('#form').validate({
                rules: {
                    title: {
                        required: true
                    },
                    bn_title: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    bn_description: {
                        required: true
                    },
                    url: {
                        required:true
                        // require_from_group: [1, '.validategroup'],

                        // required: function () {
                        //     return !$("#url").val();
                        // }

                        // required: function(element) {
                        //     return $("#url").is(':empty');
                        // }
                    },
                    doc_file: {
                        required:true
                        // require_from_group: [1, '.validategroup'],

                        // required: function () {
                        //     return !$("#doc_file").val();
                        // }

                        // required: function(element) {
                        //     return $("#doc_file").is(':empty');
                        // }
                    },
                },

                message: {
                    url: "Provide either Link or File",
                    doc_file: "Provide either Link or File",
                }
            });

            function isNumber(evt) {
                // console.log (evt);
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode == 13 || charCode == 46 || (charCode >= 48 && charCode <= 57)) {
                    return true;
                }
                return false;
            }
        });
</script>
@endsection


