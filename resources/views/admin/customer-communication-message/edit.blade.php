<div class="portlet box yellow-gold edit-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-pencil"></i>{!! trans('admin::messages.edit-name', ['name' => trans('admin::controller/customer-communication-message.customer-communication-message') ]) !!}
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form">
        {!! Form::model($customerCommunicationMessages, ['route' => ['admin.customer-communication-message.update-communication-message', $customerCommunicationMessages->id], 'method' => 'put', 'class' => 'form-horizontal panel customer-communication-message-form','id'=>'edit-customer-communication-message', 'files' => 'true', 'msg' => trans('admin::messages.updated',['name'=>trans('admin::controller/customer-communication-message.customer-communication-message')]) ]) !!}
        @include('admin::customer-communication-message.form', ['from'=>'update'])
        
        <div class="form-actions">
            <div class="row">
            <div class="col-md-6">
            <div class="row">    
                <div class="col-md-offset-4 col-md-9">
                    <button type="submit" class="btn green">{!! trans('admin::messages.save') !!}</button>
                    <button type="button" class="btn default btn-collapse btn-collapse-form-edit">{!! trans('admin::messages.cancel') !!}</button>
                </div>
                </div>
                </div>
            </div>
        </div>
        
        {!! Form::close() !!}
    </div>
</div>