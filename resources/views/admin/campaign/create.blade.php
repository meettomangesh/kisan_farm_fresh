<div class="portlet box blue add-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-plus"></i>Add New Merchant Campaign
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form display-hide">
        {!! Form::open(['route' => ['admin.merchant-campaign.store'], 'method' => 'post', 'class' => 'form-horizontal merchant-campaign-form',  'id' => 'create-merchant-campaign', 'msg' => 'Merchant Campaign added successfully.']) !!}
        @include('admin::merchant-campaign.form', ['from'=>'create'])
        <div class="form-actions">            
                <div class="col-md-offset-2">
                    <button type="submit" class="btn green">Submit</button>
                    <button type="button" class="btn default btn-collapse btn-collapse-form">Cancel</button>
                </div>            
        </div>
        {!! Form::close() !!}
    </div>
</div>