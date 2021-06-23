<tr role="row" class="filter">    
    <td>
    </td>
    <td>
    </td>    
    <td>        
        {!! Form::select('search_merchant_id', [''=>'Select Merchant'] + $merchantNames, null,['class'=>'form-control form-filter form-filter-select-attr', 'id' => 'search_merchant_id']) !!}
    </td>    
    <td>
        {!! Form::text('search_location_id', null, ['class'=>'form-control form-filter form-filter-attr']) !!}        
    </td>
    <td>
        {!! Form::text('search_brand_id', null, ['class'=>'form-control form-filter form-filter-attr']) !!}        
    </td>    
    <td>
        {!!  Form::select('search_status', ['' => 'Select',0 => trans('admin::messages.inactive'), 1 => trans('admin::messages.active')], null, ['class'=>'form-control form-filter form-filter-select-attr'])!!}
    </td>
    <td>
        <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="{!! trans('admin::messages.search') !!}"><i class="fa fa-search"></i></button>
        <button class="btn btn-sm red filter-cancel margin-bottom-5" title="{!! trans('admin::messages.reset') !!}"><i class="fa fa-times"></i></button>
    </td>     
</tr>