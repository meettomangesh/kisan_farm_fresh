@extends('admin::layouts.master')


@section('content')
@include('admin::partials.breadcrumb')
<div id="ajax-response-text"></div>

@if(!empty(Auth::guard('admin')->user()->hasAdd))
@include('admin::customer-communication-message.create')
@endif
{{--*/ $linkIcon = \Modules\Admin\Services\Helper\MenuHelper::getSelectedPageLinkIcon() /*--}}
<div id="edit_form">

</div>

<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa {{$linkIcon}} font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">{!! trans('admin::messages.view-name',['name'=>trans('admin::controller/customer-communication-message.customer-communication-messages')]) !!}</span>
        </div>
        @if(!empty(Auth::guard('admin')->user()->hasAdd))
        <div class="actions">
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">{!! trans('admin::messages.add-name',['name'=>trans('admin::controller/customer-communication-message.customer-communication-messages')]) !!} </span></a>
        </div>
        @endif
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <div class="table-actions-wrapper">
                <span></span>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            </div>
            <table class="table table-striped table-bordered table-hover" id="customer-communication-message-table">
                <thead>
                    <tr role="row" class="heading">
                        <th width='1%'>#</th>
                        <th>{!! trans('admin::controller/customer-communication-message.customer-communication-message-id') !!}</th>
                        <th width='15%'>{!! trans('admin::controller/customer-communication-message.merchant-id') !!} </th>
                        <th width='10%'>{!! trans('admin::controller/customer-communication-message.notification') !!}</th>
                        <th width='15%'>{!! trans('admin::controller/customer-communication-message.message-type') !!}</th>
                        <th width='20%'>{!! trans('admin::controller/customer-communication-message.message-title') !!}</th>
                        <th width='20%'>{!! trans('admin::controller/customer-communication-message.message-send-date-time') !!}</th>
                        <th width='10%'>{!! trans('admin::controller/customer-communication-message.email_count') !!}</th>
                        <th width='10%'>{!! trans('admin::controller/customer-communication-message.sms_count') !!}</th>
                        <th width='10%'>{!! trans('admin::controller/customer-communication-message.status') !!}</th>
                        <th width='10%'>{!! trans('admin::controller/customer-communication-message.action') !!}</th>
                    </tr>
                    <tr role="row" class="filter">
                        <td></td>
                        <td></td>
                        <td>{!!  Form::select('merchant_name', ['' => 'Select Merchant', '0'=>'Boomer'] +$merchantListData, null, ['id' => 'merchant-name-search','class'=>'select2me form-control form-filter input-sm select2-offscreen form-filter-select-attr']) !!}</td>
                        <td></td>
                        <td>{!!  Form::select('message_type', ['' => 'Select Message Type',1 => 'Package', 2 => 'Message'], null, ['id' => 'message-type-drop-down-search', 'class'=>'form-control form-filter form-filter-select-attr'])!!}</td>
                        <td>{!! Form::text('message_title', null, ['class'=>'form-control form-filter form-filter-attr']) !!}</td>
                        <td>
                            <div class="input-group date search_form_datetime margin-bottom-5" data-date="{{date('Y-m-d h:i:s')}}">
                                {!! Form::text('send_time_from', null, ['class'=>'form-control form-filter input-sm','placeholder'=>'From','disabled'=>'disabled']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-reset btn-sm" type="button"><i class="fa fa-times"></i></button>
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                            <div class="input-group date search_form_datetime" data-date="{{date('Y-m-d h:i:s')}}">
                                {!! Form::text('send_time_to', null, ['class'=>'form-control form-filter input-sm','placeholder'=>'To','disabled'=>'disabled']) !!}
                                <span class="input-group-btn">
                                    <button class="btn default date-reset btn-sm" type="button"><i class="fa fa-times"></i></button>
                                    <button class="btn default date-set btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </td>                    
                        <td></td>
                        <td></td>
                        <td>{!!  Form::select('status', ['' => 'Select Status',0 => trans('admin::messages.inactive'), 1 => trans('admin::messages.active')], null, ['id' => 'status-drop-down-search', 'class'=>'form-control form-filter form-filter-select-attr'])!!}</td>
                        <td> <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="{!! trans('admin::messages.search') !!}"><i class="fa fa-search"></i></button>
                            <button class="btn btn-sm red filter-cancel margin-bottom-5" title="{!! trans('admin::messages.reset') !!}"><i class="fa fa-times"></i></button></td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@stop


@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('global/plugins/ckeditor/ckeditor.js') ) !!}
{!! HTML::script( URL::asset('js/admin/customer-communication-message.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') ) !!}
{!! HTML::script( URL::asset('global/scripts/components-bootstrap-tagsinput.min.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') ) !!}
@stop

@section('template-level-styles')
@parent
{!! HTML::style( URL::asset('global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.customerCommunicationMessageJs.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });

</script>
@stop