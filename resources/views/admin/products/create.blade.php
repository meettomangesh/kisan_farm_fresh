@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.product.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" id="create-product" action="{{ route("admin.countries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="product_name">{{ trans('cruds.product.fields.product_name') }}</label>
                        <div class="col-md-8" style="float: right;">
                            <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" type="text" name="product_name" id="product_name" value="{{ old('product_name', '') }}" required>
                            @if($errors->has('product_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('product_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.product_name_helper') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="sku">{{ trans('cruds.product.fields.sku') }}</label>
                        <div class="col-md-8" style="float: right;">
                            <input class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" type="text" name="sku" id="sku" value="{{ old('sku', '') }}" required>
                            @if($errors->has('sku'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sku') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.sku_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="short_description">{{ trans('cruds.product.fields.short_description') }}</label>
                        <div class="col-md-8" style="float: right;">
                            <textarea class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}" rows="2" name="short_description" id="short_description" required>{{ old('short_description', '') }}</textarea>
                            @if($errors->has('short_description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('short_description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.short_description_helper') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="current_quantity">{{ trans('cruds.product.fields.opening_quantity') }}</label>
                        <div class="col-md-8" style="float: right;">
                            <input class="form-control {{ $errors->has('current_quantity') ? 'is-invalid' : '' }}" name="current_quantity" id="current_quantity" value="{{ old('current_quantity', '') }}" required greaterThanZero = "true" numberOnly="true">
                            @if($errors->has('current_quantity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('current_quantity') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.opening_quantity_helper') }}</span>
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

@section('scripts')
<!-- script src="{{ asset('js/admin/products.js') }}"></script>
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.productMerchantJs.init('create-product');
    });
</script -->
@endsection