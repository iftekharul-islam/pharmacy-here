{{--@extends('products::layouts.master')--}}
@extends('adminlte::page')

@section('adminlte_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
      .select2-container .select2-selection--single{height:auto;}
      .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 1;}
  </style>
@endsection

@section('title', 'Edit Resource')

@section('content')
    <div class="col-md-6">
        <div class="card card-primary-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Resource</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('resource.update', $data->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-sm-5 col-form-label">Title(English)</label>
                        <div class="col-sm-7" id="">
                            <input type="text" name="title" class="form-control" value="{{ $data->title }}" id="title" placeholder="Resource Title" required>
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
                            <input type="text" name="bn_title" class="form-control" value="{{ $data->bn_title }}" id="bn_title" placeholder="Resource Title(Bangla)" required>
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
                            <textarea type="text" name="description" class="form-control" id="description" placeholder="Resource Description" required>{{ $data->description }}</textarea>
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
                            <textarea type="text" name="bn_description" class="form-control" id="bn_description" placeholder="Resource Description(Bangla)" required>{{ $data->bn_description }}</textarea>
                            @if ($errors->has('bn_description'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('bn_description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($data->url)
                    <div class="form-group row">
                        <label for="url" class="col-sm-5 col-form-label">Link</label>
                        <div class="col-sm-7" id="">
                            <input type="text" name="url" class="form-control" value="{{ $data->url }}" id="url" placeholder="Link">
                            @if ($errors->has('url'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($data->files)
                    <div class="form-group row">
                        <label for="files" class="col-sm-5 col-form-label">File</label>
                        <div class="col-sm-7" id="">
                            <input type="file" name="files" class="form-control" value="" placeholder="{{ $data->files }}" id="files">
                            @if ($errors->has('files'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('files') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection




