@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.category.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.categories.update", [$category->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 required" for="cat_name">{{ trans('cruds.category.fields.cat_name') }}</label>
                    <div class="col-md-4">
                        <input class="form-control {{ $errors->has('cat_name') ? 'is-invalid' : '' }}" type="text" name="cat_name" id="cat_name" value="{{ old('cat_name', $category->cat_name) }}" required>
                        @if($errors->has('cat_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cat_name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.category.fields.cat_name_helper') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3" for="cat_description">{{ trans('cruds.category.fields.cat_description') }}</label>
                    <div class="col-md-4">
                        <textarea class="form-control {{ $errors->has('cat_description') ? 'is-invalid' : '' }}" rows="2" name="cat_description" id="cat_description">{{ old('cat_description', $category->cat_description) }}</textarea>
                        @if($errors->has('cat_description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cat_description') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.category.fields.cat_description_helper') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 required" for="status">{{ trans('cruds.category.fields.status') }}</label>
                    <div class="col-md-4">
                        <div class="radio-list">
                            <label class="radio-inline"><input type="radio" name="status" value="{{ old('status', '1') }}" required> {!! trans('cruds.category.fields.active') !!}</label>
                            <label class="radio-inline"><input type="radio" name="status" value="{{ old('status', '0') }}" required> {!! trans('cruds.category.fields.inactive') !!}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('template-level-scripts')
<script src="{{ asset('js/admin/category.js') }}"></script>
@endsection

@section('page-level-scripts')
<script src="{{ asset('global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.categoryJs.init();
    });
</script>
@endsection