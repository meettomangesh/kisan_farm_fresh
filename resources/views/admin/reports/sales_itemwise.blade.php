
@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.report.fields.sales_itemwise') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-sales-itemwise">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.sales_itemwise.fields.id') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.order_id') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.product_name') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.selling_price') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.special_price') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.item_qty') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.order_date') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.order_status') }}</th>
                    </tr>
                    <tr role="row" class="filter">
                        <td></td>
                        <td></td>
                        <td width="10%"><input type="text" placeholder="Search" /></td>
                        <td><input type="text" placeholder="Search" /></td>
                        <td><input type="text" placeholder="Search" /></td>
                        <td><input type="text" placeholder="Search" /></td>
                        <td><input type="text" placeholder="Search" /></td>
                        <td>
                            <div class="input-group date order-date margin-bottom-5" data-date="{{date('Y-m-d')}}">
                                {!! Form::text('date_of_birth_from', null, ['class'=>'form-control form-filter form-filter-attr input-sm','placeholder'=>'From','style'=>'width:95px']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                            <div class="input-group date order-date" data-date="{{date('Y-m-d')}}">
                                {!! Form::text('date_of_birth_to', null, ['class'=>'form-control form-filter form-filter-attr input-sm','placeholder'=>'To','style'=>'width:95px']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </td>
                        <th><input type="text" placeholder="Search" /></td>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('template-level-scripts')
@parent
<script src="{{ asset('js/admin/sales_itemwise.js') }}"></script>
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.SalesItemwise.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop

@endsection