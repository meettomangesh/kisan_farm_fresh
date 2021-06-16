@section('page-level-scripts')
@parent
{!! HTML::script( URL::asset('global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') ) !!}
@stop
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{!! trans('admin::controller/merchant-campaign.campaign') !!}<span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    @if($from == 'create')
                        {!! Form::select('campaign_id', [''=>'Select Campaign'] + $campaignNames, null,['class'=>'select2me form-control', 'id' => 'campaign_id', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-campaign.campaign')])]) !!}
                    @else
                        {!! Form::select('campaign_id', [''=>'Select Campaign'] + $campaignNames, null,['class'=>'select2me form-control', 'id' => 'campaign_id', 'disabled' => 'disabled', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-campaign.campaign')])]) !!}
                    @endif
                </div>   
            </div>    
        </div>                    
    </div>  
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{!! trans('admin::controller/merchant-location-brand.merchant') !!}<span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    @if($from == 'create')
                        {!! Form::select('merchant_id', [''=>'Select Merchant'] + $merchantNames, null,['class'=>'select2me form-control', 'id' => 'merchant_id', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-location-brand.merchant')])]) !!}
                    @else
                        {!! Form::select('merchant_id', [''=>'Select Merchant'] + $merchantNames, null,['class'=>'select2me form-control', 'id' => 'merchant_id', 'disabled' => 'disabled', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-location-brand.merchant')])]) !!}
                    @endif
                </div>   
            </div>    
        </div>  
    </div>    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{!! trans('admin::controller/customer-communication-message.loyalty-id') !!} <span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    @if($from == 'create')
                    {!! Form::select('loyalty_id', [''=>'Select Loyalty'], null,['class'=>'form-control', 'id' => 'loyalty_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/customer-communication-message.loyalty-id')]) ]) !!}
                    @else
                    {!! Form::select('loyalty_id', [''=>'Select Loyalty']+$loyaltyProgramsListForMerchant, null,['class'=>'form-control', 'id' => 'loyalty_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/customer-communication-message.loyalty-id')]) ]) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">    
            <div class="form-group">
                <label class="control-label col-md-4">{!! trans('admin::controller/merchant-campaign.category') !!}
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    {!! Form::select('cat_id', [''=>'Select Merchant Category']+$merchantCategories, null,['class'=>'select2me form-control', 'id' => 'cat_id', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant.merchant-category')])]) !!}
                </div>                                                                    
            </div>
        </div> 
    </div>    
    <div class="row">
        <div class="col-md-6">    
            <div class="form-group">
                <label class="col-md-4 control-label">{!! trans('admin::controller/merchant-location-brand.location') !!}<span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    @if($from == 'create')
                        {!! Form::select('location_id', [''=>'Select Location'], null,['class'=>'select2me form-control', 'id' => 'location_id', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-location-brand.location')])]) !!}                
                    @else                        
                        {!! Form::select('location_id', [''=>'Select Location']+$location, null,['class'=>'select2me form-control', 'id' => 'location_id', 'disabled' => 'disabled', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-location-brand.location')])]) !!}                                        
                    @endif      
                </div>
            </div>
        </div>  
        <div class="col-md-6">    
            <div class="form-group">
                <label class="col-md-4 control-label">{!! trans('admin::controller/merchant-location-brand.brand') !!}<span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    @if($from == 'create')
                        {!! Form::select('brand_id', [''=>'Select Brand'], null,['class'=>'select2me form-control', 'id' => 'brand_id', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-location-brand.brand')])]) !!}                
                    @else
                        {!! Form::select('brand_id', [''=>'Select Brand']+$brand, null,['class'=>'select2me form-control', 'id' => 'brand_id', 'disabled' => 'disabled', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/merchant-location-brand.brand')])]) !!}                
                    @endif                                        
                </div>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-6">    
            <div class="form-group">
                <label class="col-md-4 control-label">{!! trans('admin::controller/merchant-campaign.campaign_title') !!}<span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    {!! Form::text('campaign_title', null, ['maxlength'=>100,'class'=>'form-control', 'id'=>'campaign_title', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/merchant-campaign.campaign_title')]), 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/merchant-campaign.campaign_title')]) ])!!}                                   
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">    
            <div class="form-group">
                <label class="col-md-2 control-label">{!! trans('admin::controller/merchant-campaign.allowed_platform') !!}<span class="required" aria-required="true">*</span></label>
                <div class="col-md-10">                    
                    {!! Form::checkbox('android', 1, null, ['id' => 'android', 'class' => 'form-control']) !!}
                    {!! trans('admin::controller/merchant-campaign.android') !!}
                    
                    {!! Form::checkbox('ios', 2, null, ['id' => 'ios', 'class' => 'form-control']) !!}
                    {!! trans('admin::controller/merchant-campaign.ios') !!}
                    
                    {!! Form::checkbox('kiosk', 3, null, ['id' => 'kiosk', 'class' => 'form-control']) !!}
                    {!! trans('admin::controller/merchant-campaign.kiosk') !!}
                    
                    {!! Form::checkbox('website', 4, null, ['id' => 'website', 'class' => 'form-control']) !!}
                    {!! trans('admin::controller/merchant-campaign.website') !!}
                    
                    {!! Form::checkbox('app_only', 5, null, ['id' => 'app_only', 'class' => 'form-control']) !!}
                    {!! trans('admin::controller/merchant-campaign.app_only') !!}
                    
                    {!! Form::checkbox('all_platforms', 6, null, ['id' => 'all_platforms', 'class' => 'form-control']) !!}
                    {!! trans('admin::controller/merchant-campaign.all_platforms') !!}
                </div>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2 control-label">{!! trans('admin::controller/merchant-campaign.target_customer') !!}<span class="required" aria-required="true"> * </span></label>
                <div class="col-md-10">
                    <div class="radio-list">  
                        <label class="radio-inline">{!! Form::radio('target_customer', '1', true) !!} {!! trans('admin::controller/merchant-campaign.open') !!}</label>
                        <label class="radio-inline">{!! Form::radio('target_customer', '2') !!} {!! trans('admin::controller/merchant-campaign.membership_tier') !!}</label>
                        <label class="radio-inline">{!! Form::radio('target_customer', '3') !!} {!! trans('admin::controller/merchant-campaign.custom') !!}</label>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2 control-label">{!! trans('admin::controller/merchant-campaign.target_customer_value') !!}<span class="required" aria-required="true"> * </span></label>
                <div class="col-md-10">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2 control-label">{!! trans('admin::controller/merchant-campaign.type') !!}<span class="required" aria-required="true"> * </span></label>
                <div class="col-md-10">
                    <div class="radio-list">   
                        <label class="radio-inline">{!! Form::radio('type', '1', true) !!} {!! trans('admin::controller/merchant-campaign.generic') !!}</label>
                        <label class="radio-inline">{!! Form::radio('type', '2') !!} {!! trans('admin::controller/merchant-campaign.coupon_generic') !!}</label>
                        <label class="radio-inline">{!! Form::radio('type', '3') !!} {!! trans('admin::controller/merchant-campaign.coupon_unique') !!}</label>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">            
                <label class="col-md-4 control-label">Status <span class="required" aria-required="true">*</span></label>
                <div class="col-md-8">
                    <div class="radio-list">
                        <label class="radio-inline">{!! Form::radio('status', '1', true) !!} {!! trans('admin::messages.active') !!}</label>
                        <label class="radio-inline">{!! Form::radio('status', '0') !!} {!! trans('admin::messages.inactive') !!}</label>
                    </div>
                </div>
            </div>
        </div>    
    </div>    
</div>
