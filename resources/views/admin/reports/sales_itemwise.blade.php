
@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.report.fields.sales_itemwise') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-sales-itemwise" id="datatable-sales-itemwise">
                <thead>
                    <tr>
                        <th>{{ trans('cruds.sales_itemwise.fields.id') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.order_id') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.product_name') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.selling_price') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.special_price') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.item_qty') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.order_date') }}</th>
                        <th>{{ trans('cruds.sales_itemwise.fields.order_status') }}</th>
                        <th></th>
                    </tr>
                    <tr role="row" class="filter">
                        <td></td>
                        <td width="10%"><input name="order_id" type="text" placeholder="Search" /></td>
                        <td><input name="product_name" type="text" placeholder="Search" /></td>
                        <td><input name="selling_price" type="text" placeholder="Search" /></td>
                        <td><input name="special_price" type="text" placeholder="Search" /></td>
                        <td><input name="item_quantity" type="text" placeholder="Search" /></td>
                        <td>
                            <input class="form-control" type="date" name="order_date" id="order_date" max="{{ date('Y-m-d') }}">
                        </td>
                        <th><input name="order_status" type="text" placeholder="Search" /></td>
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

@section('template-level-scripts')
@parent
<!-- script src="{{ asset('js/admin/sales_itemwise.js') }}"></script -->
@stop

@section('scripts')
@parent
<script>
    /* jQuery(document).ready(function () {
        siteObjJs.admin.SalesItemwise.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    }); */
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            pageLength: 10,
        });
        $('.datatable-sales-itemwise thead tr:eq(1) th').each(function(i) {
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table.column(i).search(this.value).draw();
                }
            });
        });
        let table = $('.datatable-sales-itemwise').DataTable({ 
            buttons: dtButtons,
            columns:  [
                {data: null, name: 'rownum', searchable: false},
                {data: 'order_id', name: 'order_id'},
                {data: 'product_name', name: 'product_name'},
                {data: 'selling_price', name: 'selling_price'},
                {data: 'special_price', name: 'special_price'},
                {data: 'item_quantity', name: 'item_quantity'},
                {data: 'order_date', name: 'order_date'},
                {data: 'order_status', name: 'order_status'},
                {data: null, name: 'action', sortable: false}
            ],
            drawCallback: function (settings) {
                console.log('IN drawCallback');
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;
                var page = api.page();
                var recNum = null;
                var displayLength = settings._iDisplayLength;
                api.column(0, {page: 'current'}).data().each(function (group, i) {
                    recNum = ((page * displayLength) + i + 1);
                    console.log("recNum: ", recNum);
                    $(rows).eq(i).children('td:first-child').html(recNum);
                });
            },
            ajax: {
                url: "sales-itemwise/data",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            }
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script>
@stop

@endsection