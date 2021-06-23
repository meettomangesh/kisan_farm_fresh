<div class="portlet box yellow-gold edit-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-pencil"></i>Edit Merchant Campaign
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form">
        {!! Form::model($merchantCampaign, ['route' => ['admin.merchant-campaign.update', $merchantCampaign->id], 'method' => 'put', 'class' => 'form-horizontal panel','id'=>'edit-merchant-campaign', 'msg' => 'Merchant Campaign updated successfully.']) !!}
        @include('admin::merchant-campaign.form', ['from'=>'update'])
        <div class="form-actions">
                <div class="col-md-offset-2">
                    <button type="submit" class="btn green">Save</button>
                    <button type="button" class="btn default btn-collapse btn-collapse-form-edit">Cancel</button>
                </div>            
        </div>
        {!! Form::close() !!}
    </div>
</div>