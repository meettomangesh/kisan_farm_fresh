@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.product.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.product.fields.id') }}</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.product_image') }}</th>
                        <td><img src="{{ asset($product->images) }}" alt="" width="50" height="50"></td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.product_name') }}</th>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.sku') }}</th>
                        <td>{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.short_description') }}</th>
                        <td>{{ $product->short_description }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.opening_quantity') }}</th>
                        <td>{{ $product->current_quantity }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.expiry_date') }}</th>
                        <td>{{ $product->expiry_date }}</td>
                    </tr>
                    <!-- <tr>
                        <th>{{ trans('cruds.product.fields.voucher_value') }}</th>
                        <td>{{ $product->voucher_value }}</td>
                    </tr> -->
                    <tr>
                        <th>{{ trans('cruds.product.fields.selling_price') }}</th>
                        <td>{{ number_format((float)$product->selling_price, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.special_price') }}</th>
                        <td>{{ number_format((float)$product->special_price, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.special_price_start_date') }}</th>
                        <td>{{ $product->special_price_start_date }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.special_price_end_date') }}</th>
                        <td>{{ $product->special_price_end_date }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.min_quantity') }}</th>
                        <td>{{ $product->min_quantity }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.max_quantity') }}</th>
                        <td>{{ $product->max_quantity }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.stock_availability') }}</th>
                        <td>
                            @if($product->status == 1)
                                {{ trans('cruds.product.fields.in_stock') }}
                            @else
                                {{ trans('cruds.product.fields.out_of_stock') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.product.fields.status') }}</th>
                        <td>
                            @if($product->status == 1)
                                {{ trans('cruds.product.fields.active') }}
                            @else
                                {{ trans('cruds.product.fields.inactive') }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection