@section('page-level-styles')
@parent

<link href="{{ asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/jquery-file-upload/css/jquery.fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/uniform/css/uniform.default.min.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" />
<link href="{{ asset('global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
@stop
<div class="form-body">
    <h3 class="block">Whom to Send</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('cruds.communication.fields.merchant-id') }} <span class="required" aria-required="true"></span></label>
                <div class="col-md-8">
                    {!! Form::select('merchant_id', [''=>'Select Merchant' ]+$merchantListData, null,['class'=>'select2me form-control', 'id' => 'merchant_id', 'data-rule-required'=>'true', 'data-msg-required'=>"Merchant id is required" ]) !!}
                    <div class="help-block"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('cruds.communication.fields.loyalty-id') }} <span class="required" aria-required="true"></span></label>
                <div class="col-md-8">
                    @if($from == 'create')
                    {!! Form::select('loyalty_id', [''=>'Select Loyalty'], null,['class'=>'form-control', 'id' => 'loyalty_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=>"Loyalty id is required" ]) !!}
                    @else
                    {!! Form::select('loyalty_id', [''=>'Select Loyalty']+$loyaltyProgramsListForMerchant, null,['class'=>'form-control', 'id' => 'loyalty_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=>"Loyalty id is required" ]) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('cruds.communication.fields.loyalty-tier-id') }} <span class="required" aria-required="true"></span></label>
                <div class="col-md-8">
                    @if($from == 'create')
                    {!! Form::select('loyalty_tier_id[]', $loyaltyTierIdsNames, null,['class'=>'bs-select select2me form-control', 'id' => 'loyalty_tier_id', 'disabled'=>'disabled', 'data-rule-required'=>'false','multiple'=>'multiple', 'data-msg-required'=>"Loyalty tier id is required" ]) !!}
                    @else
                    <?php $selectedloyaltyTierIds = explode(',', $customerCommunicationMessages->loyalty_tier_id);
                   
                        if(count($selectedloyaltyTierIds) == count($loyaltyProgramsTiersListForMerchant)){
                            $selectedloyaltyTierIds = [0];
                        }
                        $loyaltyProgramsTiersListForMerchant[0]="All";
                        ksort($loyaltyProgramsTiersListForMerchant);
                    ?> 
                    {!! Form::select('loyalty_tier_id[]', $loyaltyProgramsTiersListForMerchant, $selectedloyaltyTierIds,['class'=>'bs-select select2me form-control', 'id' => 'loyalty_tier_id', 'disabled'=>'disabled', 'multiple'=>'multiple','data-rule-required'=>'false', 'data-msg-required'=> "Loyalty tier id is required"]) !!}
                    @endif
                </div>
            </div>
        </div>

    </div> 

    <h3 class="block">How to Send</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">{{ trans('cruds.communication.fields.notification') }}
                    <span class="required">  </span>
                </label>
                <div class="col-md-8 message-checkbox-block radio-list">
                    @if($from == 'create')
                    {!! Form::checkbox('email', 1, null, ['checked'=>'true', 'id' => 'email', 'class' => 'notification form-control']) !!}
                    @else
                    {!! Form::checkbox('email', 1, null, ['id' => 'email', 'class' => 'notification form-control']) !!}
                    @endif
                    {{ trans('cruds.communication.fields.email') }}

                    {!! Form::checkbox('push_notification', 2, null, ['id' => 'push_notification', 'class' => 'notification form-control']) !!}
                    {{ trans('cruds.communication.fields.push-notification') }}

                    {!! Form::checkbox('sms', 3, null, ['id' => 'sms',  'class' => 'notification form-control']) !!}
                    {{ trans('cruds.communication.fields.sms') }}

                    <!-- {!! Form::checkbox('sms_notification', 4, null, ['id' => 'sms_notification',  'class' => 'notification form-control']) !!}
                    {{ trans('cruds.communication.fields.sms-notification') }} -->
                </div>
            </div>
        </div>
    </div> 


    <h3 class="block">What to Send</h3>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('cruds.communication.fields.message-type') }}<span class="required" aria-required="true">  </span></label>
                <div class="col-md-8">
                    <div class="radio-list">
                        <label class="radio-inline">{!! Form::radio('message_type', '1', true) !!} {{ trans('cruds.communication.fields.message-type-1') }}</label>
                        <label class="radio-inline">{!! Form::radio('message_type', '3') !!} {{ trans('cruds.communication.fields.message-type-3') }}</label>
                        <label class="radio-inline">{!! Form::radio('message_type', '2') !!} {{ trans('cruds.communication.fields.message-type-2') }}</label>                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.message-title') }}
                    <span class="required">  </span>
                </label>
                <div class="col-md-8">                                                                        
                    {!! Form::text('message_title', null, ['maxlength'=>100,'class'=>'form-control', 'id'=>'message_title', 'data-rule-required'=>'true', 'data-msg-required'=>"Message title is require", 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>"Message title should be less than 100 chars" ])!!}                                   
                </div>
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.offer-id') }}
                    <span class="required"> </span>
                </label>
                <div class="col-md-8">    
                    @if($from == 'create')
                    {!! Form::select('offer_id', [''=>'Select Offer' ], null,['class'=>'select2me form-control', 'id' => 'offer_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=>"Please select offer ID" ]) !!}
                    @else
                    {!! Form::select('offer_id', [''=>'Select Offer' ]+$offerListForMerchant, null,['class'=>'select2me form-control', 'id' => 'offer_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=> "Please select offer ID"]) !!}
                    @endif

                </div>
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.product-id') }}
                    <span class="required"> </span>
                </label>
                <div class="col-md-8">    
                    @if($from == 'create')
                    {!! Form::select('product_id', [''=>'Select Product' ], null,['class'=>'select2me form-control', 'id' => 'product_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=>"Please select the product ID" ]) !!}
                    @else
                    {!! Form::select('product_id', [''=>'Select Product' ]+$productMerchantCollect, null,['class'=>'select2me form-control', 'id' => 'product_id', 'disabled'=>'disabled', 'data-rule-required'=>'false', 'data-msg-required'=>"Please select the product ID" ]) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="push-text-div" style="display:none">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.push-text') }}
                    <span class="required"> </span>
                </label>
                <div class="col-md-8">                                                                        
                    {!! Form::textArea('push_text', null, ['class'=>'form-control','rows'=>8,'id'=>'push_text', 'validPushText'=>'true', 'data-rule-required'=>'false', 'data-msg-required'=>"Please enter the push notification text", 'maxlength'=>320, 'data-rule-maxlength'=>'320', 'data-msg-maxlength'=>"Notification text should be 320 chars" ])!!}   
                    <div class="help-block"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.deep-link-screen') }}
                    <span class="required"> </span>
                </label>
                <div class="col-md-8">                                                                        
                    {!! Form::select('deep_link_screen', [''=>'Select Deep Link Screen' ]+$deepLinkScreeningDataGolbalList, null,['class'=>'select2me form-control', 'id' => 'deep_link_screen', 'validDeepLinkScreen'=>'true', 'data-rule-required'=>'false', 'data-msg-required'=>"Please select the deep link" ]) !!}
                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    </div> 

    <div class="row" id="sms-text-div" style="display:none">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.sms-text') }}
                    <span class="required"> </span>
                </label>
                <div class="col-md-8">                                                                        
                    {!! Form::textArea('sms_text', null, ['class'=>'form-control','rows'=>8,'id'=>'sms_text', 'validSmsText'=>'true', 'data-rule-required'=>'false', 'data-msg-required'=>"Please enter the SMS text", 'maxlength'=>480, 'data-rule-maxlength'=>'480', 'data-msg-maxlength'=>"SMS text should be less than 480 chars" ])!!}   
                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="email-div">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">{{ trans('cruds.communication.fields.email-from-name') }}
                        <span class="required">  </span>
                    </label>
                    <div class="col-md-8">                                                                        
                        {!! Form::text('email_from_name', null, ['maxlength'=>100,'class'=>'form-control', 'id'=>'email_from_name', 'data-rule-required'=>'false', 'validEmailFromName'=>'true', 'data-msg-required'=>"Please enter the email from name", 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>"Email from name should be less than 100 chars" ])!!}                                   
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">{{ trans('cruds.communication.fields.email-from-email') }}
                        <span class="required"> </span>
                    </label>
                    <div class="col-md-8">                                                                        
                        {!! Form::text('email_from_email', null, ['maxlength'=>100,'class'=>'form-control', 'id'=>'email_from_email', 'data-rule-required'=>'false', 'validEmailFromEmail'=>'true', 'validEmail'=>'true', 'data-msg-required'=>"Please enter the from email address", 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=> "From email should be less than 100 chars"])!!}                                   
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">{{ trans('cruds.communication.fields.email-subject') }}
                        <span class="required"> </span>
                    </label>
                    <div class="col-md-8">                                                                        
                        {!! Form::text('email_subject', null, ['maxlength'=>200,'class'=>'form-control', 'id'=>'email_subject', 'data-rule-required'=>'false', 'validEmailSubject'=>'true', 'data-msg-required'=>"Please enter the email subject", 'data-rule-maxlength'=>'200', 'data-msg-maxlength'=>"Email subject should be less than 200 chars" ])!!}                                   
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">{{ trans('cruds.communication.fields.email-body') }}
                        <span class="required">  </span>
                    </label>
                    <div class="col-md-10">                                                                        
                        {!! Form::textarea('email_body', null, ['class'=>'ckeditor form-control', 'validEmailBody'=>'true', 'maxlength'=>1000, 'id'=>'email_body']) !!}                                   
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">{{ trans('cruds.communication.fields.email-tags') }}
                        <span class="required">  </span>
                    </label>
                    <div class="col-md-10">                                                                        
                        {!! Form::text('email_tags', null, ['maxlength'=>250,'class'=>'form-control', 'id'=>'email_tags', 'data-role'=> 'tagsinput', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.email-tags')]), 'data-rule-maxlength'=>'250', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.email-tags')]) ])!!}                                   
                    </div>
                </div>
            </div>


        </div> -->


    </div>
    <h3 class="block">When to Send</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Send Today
                    <span class="required"> </span>
                </label>
                <div class="col-md-8 message-checkbox-block">                                                                                            
                    {!! Form::checkbox('send_today', 1, null, ['id' => 'send_today', 'class' => 'send_today form-control']) !!}
                    <div id="send_today_message"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="message-send-date-div">
        <div class="col-md-6" id="row-message-send-date-div">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.message-send-date') }}
                    <span class="required">  </span>
                </label>
                <div class="col-md-8">                                                                        
                    <div data-error-container="#form_start_date_error" class="input-group date form_datetime" data-date-start-date="+0d" >
                        {!! Form::text('message_send_time', null, ['id' => 'message_send_time', 'class'=>'form-control','readonly'=>'true', 'data-rule-required'=>'true', 'data-msg-required'=>"Please enter the message send date" ]) !!}
                        <span class="input-group-btn">
                            <button class="btn default date-set" type="button" id="date-picker-btn"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                    <div class="help-block">You can edit this Message/Offer till previous day mid-night of Send Date.</div>
                    <div id="form_start_date_error"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="today_time_div">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.message-send-time') }} <span class="required">  </span></label>
                <div class="col-md-8">
                    <div class="input-group">
                        {!! Form::text('today_time', null, ['class'=>'form-control timepicker', 'id'=>'today_time', 'readonly'=>'true', 'data-rule-required'=>'true', 'data-msg-required'=>"Please enter the message send time" ]) !!}
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">{{ trans('cruds.communication.fields.status') }}<span class="required" aria-required="true"></span></label></label>
                <div class="col-md-8">
                    <div class="radio-list">
                        <label class="radio-inline">{!! Form::radio('status', '1', true) !!} {{ trans('cruds.communication.fields.active') }}</label>
                        <label class="radio-inline">{!! Form::radio('status', '2') !!} {{ trans('cruds.communication.fields.inactive') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="block">Test Mode</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">{{ trans('cruds.communication.fields.for-testing') }}
                    <span class="required"> </span>
                </label>
                <div class="col-md-8">                                                                        
                    {!!  Form::select('for_testing', [1 => 'Yes', 0 => 'No'], 0, ['id' => 'for_testing', 'class'=>'form-control'])!!}
                </div>
            </div>
        </div>

    </div>
    <div id="testing-mode-div" style="display:none">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">{{ trans('cruds.communication.fields.test-email-addresses') }}
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-8">                                                                        
                        {!! Form::text('test_email_addresses', null, ['class'=>'form-control','id'=>'test_email_addresses', 'data-rule-required'=>'false', 'validEmail'=>'true', 'data-msg-required'=>"Please enter test email address", 'maxlength'=>100, 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>"Test email address should be less than 100 chars" ])!!}    
                        <div class="help-block">{{ trans('cruds.communication.fields.help-test-email-addresses') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 send-test-message-div">
                <div class="form-group">
                    <label class="control-label col-md-4">{{ trans('cruds.communication.fields.test-mobile-numbers') }}
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-8">                                                                        
                        {!! Form::text('test_mobile_numbers', null, ['class'=>'form-control','id'=>'test_mobile_numbers', 'data-rule-required'=>'false', 'data-msg-required'=>"Plesae enter test mobile number", 'maxlength'=>10, 'data-rule-maxlength'=>'10', 'data-msg-maxlength'=>"Test mobile number should be 10 chars" ])!!}    
                        <div class="help-block">{{ trans('cruds.communication.fields.help-test-mobile-numbers') }}</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">

                    </label>
                    <div class="col-md-8">                                                                        
                        <button type="button" data-action="send-email" id="send-email-btn" title="Send" data-id="2" class="btn btn-sm red send-email view"><i class="fa fa-envelope"></i> Send Test Email</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 send-test-message-div">
                <div class="form-group">
                    <label class="control-label col-md-4">

                    </label>
                    <div class="col-md-8">                                                                        
                        <button type="button" data-action="send-sms" id="send-sms-btn" title="Send" data-id="2" class="btn btn-sm red send-sms view"><i class="fa fa-mobile"></i> Send Test SMS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('page-level-scripts')
@parent
<script src="{{ asset('global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
@stop