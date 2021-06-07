@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.order.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
        <form method="POST" action="{{ route("admin.orders.update", [$customerOrder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="delivery_date">{{ trans('cruds.order.fields.delivery_date') }}</label>
                        <div class="col-md-8 float-right">
                            <!-- div data-error-container="#form_special_price_start_date_error" class="input-group date form_datetime" data-date-start-date="+0d" -->
                                <input class="form-control {{ $errors->has('delivery_date') ? 'is-invalid' : '' }}" type="date" name="delivery_date" id="delivery_date" min="{{ ($customerOrder->special_price_start_date) ? $customerOrder->delivery_date : date('Y-m-d') }}" value="{{ old('delivery_date', $customerOrder->delivery_date) }}" startDateValid="true">
                                <!-- span class="input-group-btn">
                                    <button class="btn default date-set" type="button" id="date-picker-btn"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div -->
                            <span class="help-block">{{ trans('cruds.order.fields.delivery_date_helper') }}</span>
                            <div id="form_delivery_date_error"></div>
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
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
</div>

@endsection