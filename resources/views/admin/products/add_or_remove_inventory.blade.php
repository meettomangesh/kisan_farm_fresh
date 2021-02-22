@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.product.fields.add_or_remove_product_inventory') }}
    </div>

    <div class="card-body">
        <form method="POST" id="product-add-or-remove-inventory" action="{{ route("admin.products.storeInventory") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="product_name">{{ trans('cruds.product.fields.product_name') }}</label>
                        <div class="col-md-8 float-right">
                            <label>{{ $product['product_name'] }}</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="quantity">{{ trans('cruds.product.fields.quantity') }}</label>
                        <div class="col-md-8 float-right">
                            <input type="number" min="1" max="5000" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" name="quantity" id="quantity" value="{{ old('quantity', '') }}" required>
                            @if($errors->has('quantity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('quantity') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.quantity_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="inventory_type">{{ trans('cruds.product.fields.inventory_type') }}</label>
                        <div class="col-md-8 float-right">
                            <div class="radio-list">
                                <label class="radio-inline"><input type="radio" name="inventory_type" value="{{ old('inventory_type', '1') }}" checked required> {!! trans('cruds.product.fields.add') !!}</label>
                                <label class="radio-inline"><input type="radio" name="inventory_type" value="{{ old('inventory_type', '0') }}" required> {!! trans('cruds.product.fields.remove') !!}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
                <input type="hidden" name="product_id" id="product_id" value="{{ $product['id'] }}"/>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    jQuery(document).ready(function () {
        $('#quantity').bind('keyup paste', function(){
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection