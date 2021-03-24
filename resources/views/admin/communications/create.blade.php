@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.country.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.countries.store") }}" enctype="multipart/form-data">
            @csrf
            <!-- <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.country.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="short_code">{{ trans('cruds.country.fields.short_code') }}</label>
                <input class="form-control {{ $errors->has('short_code') ? 'is-invalid' : '' }}" type="text" name="short_code" id="short_code" value="{{ old('short_code', '') }}" required>
                @if($errors->has('short_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.short_code_helper') }}</span>
            </div> -->
            <div class="form-body">
                <h3 class="block">Whom to Send</h3>
                <div class="row">
                    <div class="col-md-6">

                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-8">

                                <!-- <label class="required" for="filter_or_upload">{{ trans('cruds.communication.fields.filter_or_upload') }}</label> -->
                                <div class="radio-list">
                                        <label class="radio-inline"><input type="radio" name="filter_or_upload" value="{{ old('filter_or_upload', '1') }}" checked required> {!! trans('cruds.communication.fields.apply_filters') !!}</label>
                                        <label class="radio-inline"><input type="radio" name="filter_or_upload" value="{{ old('filter_or_upload', '2') }}" required> {!! trans('cruds.communication.fields.upload_files') !!}</label>
                                </div>
                                @if($errors->has('filter_or_upload'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('filter_or_upload') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.communication.fields.filter_or_upload_helper') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id='filter_div1'>        
                    <div class="col-md-6">
                        <div class="form-group">
                        
                            <label class="required" for="gender_filter">{{ trans('cruds.communication.fields.gender') }}</label>
                            <div class="col-md-8 float-right">
                                <select class="form-control select2 {{ $errors->has('gender_filter') ? 'is-invalid' : '' }}" name="gender_filter" id="gender_filter" required>
                                    @foreach(['0'=>'All','1'=>'Male','2'=>'Female','3'=>'Other' ] as $id => $gender)
                                        <option value="{{ $id }}" {{ old('gender_filter') == $id ? 'selected' : '' }}>{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('gender_filter'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender_filter') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.communication.fields.gender_filter') }}</span>

                        </div>
                    </div>
                </div>      
               <div class="row hidden"  id='upload_div'>        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="upload_type">{{ trans('cruds.communication.fields.upload_type') }}</label>
                            <div class="radio-list">
                                    <label class="radio-inline"><input type="radio" name="upload_type" value="{{ old('upload_type', '1') }}" checked required> {!! trans('cruds.communication.fields.emails') !!}</label>
                                    <label class="radio-inline"><input type="radio" name="upload_type" value="{{ old('upload_type', '2') }}" required> {!! trans('cruds.communication.fields.mobiles') !!}</label>
                            </div>
                            @if($errors->has('upload_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('upload_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.communication.fields.upload_type_helper') }}</span>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">{!! trans('admin::controller/customer-communication-message.upload') !!} <span class="required hidden" aria-required="true" id="upload_span"></span></label>
                            <div class="col-md-8">
                                
                                
                            <input type="file" name="upload_file" class="upload_file" accept="image/*"  required/>
                            <span class="fileupload-process"></span>
                            <span id="file-error-container"></span>
                            <span class="help-block">{{ trans('cruds.communication.fields.upload_file_helper') }}</span>
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

                            <div class="checkbox-list">
                                <label class="checkbox-inline"><input type="checkbox" name="email" value="{{ old('email', '1') }}" checked required> {{ trans('cruds.communication.fields.email') }}</label>
                                <label class="checkbox-inline"><input type="checkbox" name="sms" value="{{ old('sms', '2') }}" required> {{ trans('cruds.communication.fields.sms') }} </label>
                            </div>
                            <!-- @if($errors->has('upload_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('upload_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.communication.fields.upload_type_helper') }}</span> -->

                        </div>
                    </div>
                </div> 


               <h3 class="block">What to Send</h3>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">{!! trans('admin::controller/customer-communication-message.message-type') !!}<span class="required" aria-required="true"> * </span></label>
                            <div class="col-md-8">
                                <div class="radio-list">
                                    <label class="radio-inline">{!! Form::radio('message_type', '1', true) !!} {!! trans('admin::controller/customer-communication-message.message-type-1') !!}</label>
                                    <label class="radio-inline">{!! Form::radio('message_type', '2') !!} {!! trans('admin::controller/customer-communication-message.message-type-2') !!}</label>                        
                                </div>
                                <div class="radio-list">
                                    <label class="radio-inline"><input type="radio" name="message_type" value="{{ old('message_type', '1') }}" checked required> {!! trans('cruds.communication.fields.message-type-1') !!}</label>
                                    <label class="radio-inline"><input type="radio" name="message_type" value="{{ old('message_type', '2') }}" required> {!! trans('cruds.communication.fields.message-type-2') !!}</label>
                                </div>
                                @if($errors->has('message_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('message_type') }}
                                </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.communication.fields.message_type_helper') }}</span>

                            </div>
                        </div>
                    </div>

                    <?php /* <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.message-title') !!}
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">                                                                        
                                {!! Form::text('message_title', null, ['maxlength'=>100,'class'=>'form-control', 'id'=>'message_title', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.message-title')]), 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.message-title')]) ])!!}                                   
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.message-type-1') !!}
                                <span class="required"> </span>
                            </label>
                            <div class="col-md-8">    
      
                                {!! Form::select('package_id', [''=>'Select Package' ], null,['class'=>'select2me form-control', 'id' => 'package_id', 'disabled'=>'disabled', 'autocomplete'  => 'off', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/customer-communication-message.message-type-1')]) ]) !!}


                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row" id="push-text-div" style="display:none">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.push-text') !!}
                                <span class="required"> </span>
                            </label>
                            <div class="col-md-8">                                                                        
                                {!! Form::textArea('push_text', null, ['class'=>'form-control','rows'=>8,'id'=>'push_text', 'validPushText'=>'true', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.push-text')]), 'maxlength'=>320, 'data-rule-maxlength'=>'320', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.push-text')])])!!}   
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.deep-link-screen') !!}
                                <span class="required"> </span>
                            </label>
                            <div class="col-md-8">                                                                        
                                {!! Form::select('deep_link_screen', [''=>'Select Deep Link Screen' ]+$deepLinkScreeningDataGolbalList, null,['class'=>'select2me form-control', 'id' => 'deep_link_screen', 'autocomplete'  => 'off', 'validDeepLinkScreen'=>'true', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/customer-communication-message.deep-link-screen')]) ]) !!}
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="row" id="sms-text-div" style="display:none">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.sms-text') !!}
                                <span class="required"> </span>
                            </label>
                            <div class="col-md-8">                                                                        
                                {!! Form::textArea('sms_text', null, ['class'=>'form-control','rows'=>8,'id'=>'sms_text', 'validSmsText'=>'true', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.sms-text')]), 'maxlength'=>480, 'data-rule-maxlength'=>'480', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.sms-text')])])!!}   
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="email-div">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.email-from-name') !!}
                                    <span class="required">  </span>
                                </label>
                                <div class="col-md-8">                                                                        
                                    {!! Form::text('email_from_name', null, ['maxlength'=>100,'class'=>'form-control', 'id'=>'email_from_name', 'data-rule-required'=>'false', 'validEmailFromName'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.email-from-name')]), 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.email-from-name')]) ])!!}                                   
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.email-from-email') !!}
                                    <span class="required"> </span>
                                </label>
                                <div class="col-md-8">                                                                        
                                    {!! Form::text('email_from_email', null, ['maxlength'=>100,'class'=>'form-control', 'id'=>'email_from_email', 'data-rule-required'=>'false', 'validEmailFromEmail'=>'true', 'validEmail'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.email-from-email')]), 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.email-from-email')]) ])!!}                                   
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.email-subject') !!}
                                    <span class="required">  </span>
                                </label>
                                <div class="col-md-8">                                                                        
                                    {!! Form::text('email_subject', null, ['maxlength'=>200,'class'=>'form-control', 'id'=>'email_subject', 'data-rule-required'=>'false', 'validEmailSubject'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.email-subject')]), 'data-rule-maxlength'=>'200', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.email-subject')]) ])!!}                                   
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2">{!! trans('admin::controller/customer-communication-message.email-body') !!}
                                    <span class="required">  </span>
                                </label>
                                <div class="col-md-10">                                                                        
                                    {!! Form::textarea('email_body', null, ['class'=>'ckeditor form-control', 'validEmailBody'=>'true', 'id'=>'email_body']) !!}                                   
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2">{!! trans('admin::controller/customer-communication-message.email-tags') !!}
                                    <span class="required">  </span>
                                </label>
                                <div class="col-md-10">                                                                        
                                    {!! Form::text('email_tags', null, ['maxlength'=>250,'class'=>'form-control', 'id'=>'email_tags', 'data-role'=> 'tagsinput', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.email-tags')]), 'data-rule-maxlength'=>'250', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.email-tags')]) ])!!}                                   
                                </div>
                            </div>
                        </div>
                    </div>


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
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.message-send-date') !!}
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">                                                                        
                                <div data-error-container="#form_start_date_error" class="input-group date form_datetime" data-date-start-date="+0d" >
                                    {!! Form::text('message_send_time', null, ['id' => 'message_send_time', 'class'=>'form-control','readonly'=>'true', 'autocomplete'  => 'off', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/customer-communication-message.message-send-date')])]) !!}
                                    <span class="input-group-btn">
                                        <button class="btn default date-set" type="button" id="date-picker-btn"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <div class="help-block">You can edit this Message/Package till previous day mid-night of Send Date.</div>
                                <div id="form_start_date_error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="today_time_div">
                        <div class="form-group">
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.message-send-time') !!} <span class="required"> * </span></label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    {!! Form::text('today_time', null, ['class'=>'form-control timepicker', 'id'=>'today_time', 'readonly'=>'true', 'autocomplete'  => 'off', 'data-rule-required'=>'true', 'data-msg-required'=>trans('admin::messages.required-select', ['name' => trans('admin::controller/customer-communication-message.message-send-time')]) ]) !!}
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
                            <label class="col-md-4 control-label">{!! trans('admin::controller/customer-communication-message.status') !!}<span class="required" aria-required="true">*</span></label></label>
                            <div class="col-md-8">
                                <div class="radio-list">
                                    <label class="radio-inline">{!! Form::radio('status', '1', true) !!} {!! trans('admin::messages.active') !!}</label>
                                    <label class="radio-inline">{!! Form::radio('status', '2') !!} {!! trans('admin::messages.inactive') !!}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="block">Test Mode</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.for-testing') !!}
                                <span class="required"> </span>
                            </label>
                            <div class="col-md-8">                                                                        
                                {!!  Form::select('for_testing', [1 => 'Yes', 0 => 'No'], 0, ['id' => 'for_testing', 'autocomplete'  => 'off', 'class'=>'form-control'])!!}
                            </div>
                        </div>
                    </div>

                </div>
                <div id="testing-mode-div" style="display:none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.test-email-addresses') !!}
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">                                                                        
                                    {!! Form::text('test_email_addresses', null, ['class'=>'form-control','id'=>'test_email_addresses', 'data-rule-required'=>'false', 'validEmail'=>'true', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.test-email-addresses')]), 'maxlength'=>100, 'data-rule-maxlength'=>'100', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.test-email-addresses')])])!!}    
                                    <div class="help-block">{!! trans('admin::controller/customer-communication-message.help-test-email-addresses') !!}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 send-test-message-div">
                            <div class="form-group">
                                <label class="control-label col-md-4">{!! trans('admin::controller/customer-communication-message.test-mobile-numbers') !!}
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">                                                                        
                                    {!! Form::text('test_mobile_numbers', null, ['class'=>'form-control','id'=>'test_mobile_numbers', 'data-rule-required'=>'false', 'data-msg-required'=>trans('admin::messages.required-enter', ['name' => trans('admin::controller/customer-communication-message.test-mobile-numbers')]), 'maxlength'=>10, 'data-rule-maxlength'=>'10', 'data-msg-maxlength'=>trans('admin::messages.error-maxlength', ['name'=>trans('admin::controller/customer-communication-message.test-mobile-numbers')])])!!}    
                                    <div class="help-block">{!! trans('admin::controller/customer-communication-message.help-test-mobile-numbers') !!}</div>
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
            </div>  */ ?>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection