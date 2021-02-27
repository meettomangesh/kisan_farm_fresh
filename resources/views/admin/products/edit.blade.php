@extends('layouts.admin')
@section('page-level-styles')
<link href="{{ asset('global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/cubeportfolio/css/cubeportfolio.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/jquery-file-upload/css/jquery.fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.product.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" id="edit-product" action="{{ route("admin.products.update", [$product->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="product_name">{{ trans('cruds.product.fields.product_name') }}</label>
                        <div class="col-md-8 float-right">
                            <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" maxlength="50" required>
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
                        <div class="col-md-8 float-right">
                            <input class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" maxlength="50" required>
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
                        <div class="col-md-8 float-right">
                            <textarea class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}" rows="2" name="short_description" id="short_description" maxlength="250" required>{{ old('short_description', $product->short_description) }}</textarea>
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
                        <div class="col-md-8 float-right">
                            <input class="form-control {{ $errors->has('current_quantity') ? 'is-invalid' : '' }}" name="current_quantity" id="current_quantity" value="{{ old('current_quantity', $product->current_quantity) }}" greaterThanZero = "true" numberOnly="true" disabled>
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

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="category_id">{{ trans('cruds.product.fields.category') }}</label>
                        <div class="col-md-8 float-right">
                            <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                                @foreach($categories as $id => $category)
                                    <option value="{{ $id }}" {{ ($product->category ? $product->category->id : old('category_id')) == $id ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category') }}
                        </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.product.fields.category_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="units">{{ trans('cruds.product.fields.units') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('units') ? 'is-invalid' : '' }}" name="unit_ids[]" id="unit_ids" multiple required>
                            @foreach($productUnits as $key)
                                <option value="{{ $key->id }}" selected>{{ $key->unit }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('units'))
                            <div class="invalid-feedback">
                                {{ $errors->first('units') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.product.fields.units_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="expiry_date">{{ trans('cruds.product.fields.expiry_date') }}</label>
                        <div class="col-md-8 float-right">
                            <!--div data-error-container="#form_expiry_date_error" class="input-group date form_datetime" data-date-start-date="+0d" -->
                                <input class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}" type="date" name="expiry_date" id="expiry_date" min="{{ date('Y-m-d') }}" value="{{ old('expiry_date', $product->expiry_date) }}">
                                <!-- span class="input-group-btn">
                                    <button class="btn default date-set" type="button" id="date-picker-btn"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div -->
                            <span class="help-block">{{ trans('cruds.product.fields.expiry_date_helper') }}</span>
                            <div id="form_expiry_date_error"></div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="voucher_value">{{ trans('cruds.product.fields.voucher_value') }}</label>
                        <div class="col-md-8 float-right">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-inr"></i>
                                </span>
                                <input class="form-control {{ $errors->has('voucher_value') ? 'is-invalid' : '' }}" name="voucher_value" id="voucher_value" value="{{ old('voucher_value', round($product->voucher_value, 2)) }}" greaterThanZero = "true" numberOnly="true" maxlength="10" autocomplete="off" required>
                            </div>
                            <span class="help-block">{{ trans('cruds.product.fields.voucher_value_helper') }}</span>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="voucher_value">{{ trans('cruds.product.fields.selling_price') }}</label>
                        <div class="col-md-8 float-right">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-inr"></i>
                                </span>
                                <input class="form-control {{ $errors->has('selling_price') ? 'is-invalid' : '' }}" name="selling_price" id="selling_price" value="{{ old('selling_price', round($product->selling_price, 2)) }}" greaterThanZero = "true" numberOnly="true" maxlength="10" autocomplete="off" required>
                            </div>
                            <span class="help-block">{{ trans('cruds.product.fields.selling_price_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="special_price">{{ trans('cruds.product.fields.special_price') }}</label>
                        <div class="col-md-8 float-right">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-inr"></i>
                                </span>
                                <input class="form-control {{ $errors->has('special_price') ? 'is-invalid' : '' }}" name="special_price" id="special_price" value="{{ old('special_price', $product->special_price > 0 ? round($product->special_price, 2) : '') }}" greaterThanZero = "true" numberOnly="true" priceRangeValid="true" maxlength="10" autocomplete="off">
                            </div>
                            <span class="help-block">{{ trans('cruds.product.fields.special_price_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="special_price_start_date">{{ trans('cruds.product.fields.special_price_start_date') }}</label>
                        <div class="col-md-8 float-right">
                            <!-- div data-error-container="#form_special_price_start_date_error" class="input-group date form_datetime" data-date-start-date="+0d" -->
                                <input class="form-control {{ $errors->has('special_price_start_date') ? 'is-invalid' : '' }}" type="date" name="special_price_start_date" id="special_price_start_date" min="{{ ($product->special_price_start_date) ? $product->special_price_start_date : date('Y-m-d') }}" value="{{ old('special_price_start_date', $product->special_price_start_date) }}" startDateValid="true">
                                <!-- span class="input-group-btn">
                                    <button class="btn default date-set" type="button" id="date-picker-btn"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div -->
                            <span class="help-block">{{ trans('cruds.product.fields.special_price_start_date_helper') }}</span>
                            <div id="form_special_price_start_date_error"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="special_price_end_date">{{ trans('cruds.product.fields.special_price_end_date') }}</label>
                        <div class="col-md-8 float-right">
                            <!-- div data-error-container="#form_special_price_end_date_error" class="input-group date form_datetime" data-date-start-date="+0d" -->
                                <input class="form-control {{ $errors->has('special_price_end_date') ? 'is-invalid' : '' }}" type="date" name="special_price_end_date" id="special_price_end_date" min="{{ ($product->special_price_end_date) ? $product->special_price_end_date : date('Y-m-d') }}" value="{{ old('special_price_end_date', $product->special_price_end_date) }}" endDateValid="true">
                                <!-- span class="input-group-btn">
                                    <button class="btn default date-set" type="button" id="date-picker-btn"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div -->
                            <span class="help-block">{{ trans('cruds.product.fields.special_price_end_date_helper') }}</span>
                            <div id="form_special_price_end_date_error"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="min_quantity">{{ trans('cruds.product.fields.min_quantity') }}</label>
                        <div class="col-md-8 float-right">
                            <input class="form-control {{ $errors->has('min_quantity') ? 'is-invalid' : '' }}" name="min_quantity" id="min_quantity" value="{{ old('min_quantity', $product->min_quantity) }}" greaterThanZero = "true" numberOnly="true" maxlength="10" autocomplete="off" required>
                            <span class="help-block">{{ trans('cruds.product.fields.min_quantity_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="max_quantity">{{ trans('cruds.product.fields.max_quantity') }}</label>
                        <div class="col-md-8 float-right">
                            <input class="form-control {{ $errors->has('max_quantity') ? 'is-invalid' : '' }}" name="max_quantity" id="max_quantity" value="{{ old('max_quantity', $product->max_quantity) }}" greaterThanZero = "true" numberOnly="true" quantityValid="true" maxlength="10" autocomplete="off" required>
                            <span class="help-block">{{ trans('cruds.product.fields.max_quantity_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="stock_availability">{{ trans('cruds.product.fields.stock_availability') }}</label>
                        <div class="col-md-8 float-right">
                            <div class="radio-list">
                                <label class="radio-inline"><input type="radio" name="stock_availability" value="{{ old('stock_availability', '1') }}" {{ $product->stock_availability == '1' ? 'checked' : '' }} required> {!! trans('cruds.product.fields.in_stock') !!}</label>
                                <label class="radio-inline"><input type="radio" name="stock_availability" value="{{ old('stock_availability', '0') }}" {{ $product->stock_availability == '0' ? 'checked' : '' }} required> {!! trans('cruds.product.fields.out_of_stock') !!}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4 required" for="status">{{ trans('cruds.product.fields.status') }}</label>
                        <div class="col-md-8 float-right">
                            <div class="radio-list">
                                <label class="radio-inline"><input type="radio" name="status" value="{{ old('status', '1') }}" {{ $product->status == '1' ? 'checked' : '' }} required> {!! trans('cruds.product.fields.active') !!}</label>
                                <label class="radio-inline"><input type="radio" name="status" value="{{ old('status', '0') }}" {{ $product->status == '0' ? 'checked' : '' }} required> {!! trans('cruds.product.fields.inactive') !!}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="fileupload-buttonbar form-group">
                        <label class="col-md-4 control-label required">{{ trans('cruds.product.fields.product_images') }}</label>
                        <div class="col-md-8 float-right">
                            <input type="file" name="product_images[]" class="product_images" accept="image/*"  multiple/>
                            <span class="fileupload-process"></span>
                            <span id="file-error-container"></span>
                            <span class="help-block">{{ trans('cruds.product.fields.product_images_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(sizeof($productImages) > 0)
            <div class="row product-image-div">
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="col-md-12 col-xs-offset-3">
                            <div class="files-table table-container">
                                <table role="presentation" class="table table-striped table-bordered clearfix table-border-separate" id="image-preview-table">
                                    <thead>
                                        <tr>
                                            <th width="1%" class="text-center">#</th>
                                            <th class="text-center">{{ trans('cruds.product.fields.preview') }}</th>
                                            <!-- th>{{ trans('cruds.product.fields.file_name') }}</th>
                                            <th>{{ trans('cruds.product.fields.image_description') }}</th>
                                            <th>{{ trans('cruds.product.fields.display_order') }}</th -->
                                            <th class="text-center">{{ trans('cruds.product.fields.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="files" id="dvPreview">
                                        @foreach($productImages as $key => $image)
                                            <tr class="row-for-blank" id="blank-row-{{ $image->id }}">
                                                <td class="text-center">{{ $srNo = $srNo + 1 }}</td>
                                                <td class="text-center"><img src="{{ asset($image->image_name) }}" alt="" width="60" height="60"></td>
                                                <td class="text-center"><span class="btn red" id="remove-btn" data-display-order="{{ $image->display_order }}" data-image-id="{{ $image->id }}">Remove</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
                <input type="hidden" name="removed_images" id="removed_images" />
            </div>
        </form>
    </div>
</div>

@endsection

@section('template-level-scripts')
<script src="{{ asset('js/admin/products.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endsection

@section('page-level-scripts')
<script src="{{ asset('global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}"></script>
<script src="{{ asset('global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}"></script>
<script src="{{ asset('global/plugins/cubeportfolio/js/jquery.cubeportfolio.js') }}"></script>
<script src="{{ asset('global/plugins/owl.carousel.min.js') }}"></script>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.productMerchantJs.init('edit-product');

        $('select[name="category_id"]').on('change', function() {
            var categoryId = $(this).val();
            var url = '{{ route("admin.products.getUnits", "") }}';
            url = url+'/'+categoryId;

            if (categoryId) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $("#unit_ids").empty();
                        $.each(data, function(key, value) {
                            $("#unit_ids").append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $("#unit_ids").empty();
            }
        });
    });
</script>
@endsection