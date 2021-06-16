@extends('admin::layouts.master')

@section('content')
@include('admin::partials.breadcrumb')
<div id="ajax-response-text"></div>

@if(!empty(Auth::guard('admin')->user()->hasAdd))
@include('admin::merchant-campaign.create')
@endif

{{--*/ $linkIcon = \Modules\Admin\Services\Helper\MenuHelper::getSelectedPageLinkIcon() /*--}}

<div id="edit_form">

</div>
<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa {{ $linkIcon }} font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">View Merchant Campaign</span>
        </div>
        @if(!empty(Auth::guard('admin')->user()->hasAdd))
        <div class="actions">
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">Add New Merchant Campaign </span></a>
        </div>
        @endif
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <table class="table table-striped table-bordered table-hover" id="merchant-campaign-table">
                <thead>
                    <tr role="row" class="heading">
                        <th>#</th>
                        <th width='5%'>ID</th>                                                
                        <th width='5%'>Merchant Name</th>                        
                        <th width='15%'>Location</th>
                        <th width='25%'>Brand</th>                                                                  
                        <th width='5%'>Status</th>
                        <th width='10%'>Options</th>
                    </tr>
                    @include('admin::merchant-campaign.search')
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
{!! HTML::script( URL::asset('js/admin/merchant-campaign.js') ) !!}
{!! HTML::script( URL::asset('global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') ) !!}
{!! HTML::script( URL::asset('global/scripts/components-bootstrap-tagsinput.min.js') ) !!}
@stop
@section('template-level-styles')
@parent
{!! HTML::style( URL::asset('global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') ) !!}
@stop
@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.merchantCampaignJs.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();        
    });
</script>
@stop
